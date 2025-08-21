<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;


class InstallerController extends Controller
{
    private string $stateFile;

    public function __construct()
    {
        $this->stateFile = storage_path('app/installer/state.json');
    }

    private function getState(): array
    {
        if (!File::exists($this->stateFile)) {
            return ['step' => 0, 'installed' => false];
        }
        return json_decode(File::get($this->stateFile), true) ?: ['step'=>0,'installed'=>false];
    }

    private function putState(array $data): void
    {
        File::ensureDirectoryExists(dirname($this->stateFile));
        File::put($this->stateFile, json_encode($data, JSON_PRETTY_PRINT));
    }

    /** --------------------------
     * Step 1 — System Requirements
     * -------------------------- */
    public function step1()
    {
        $phpVersion = PHP_VERSION;
        $phpOk = version_compare(PHP_VERSION, config('installer.min_php', '8.1'), '>=');

        // Use config list (no hardcoded extensions)
        $extList = config('installer.extensions', ['openssl','pdo','mbstring','xml','ctype','json']);
        $results = [];
        foreach ($extList as $ext) $results[$ext] = extension_loaded($ext);

        // Ensure uploads folder exists so we can check writability
        if (!is_dir(public_path('uploads'))) @mkdir(public_path('uploads'), 0775, true);

        $folderKeys = config('installer.folders', ['storage','bootstrap/cache','public/uploads']);
        $folders = [];
        foreach ($folderKeys as $rel) {
            $abs = match ($rel) {
                'storage'          => storage_path(),
                'bootstrap/cache'  => base_path('bootstrap/cache'),
                'public/uploads'   => public_path('uploads'),
                default            => base_path($rel),
            };
            $folders[$abs] = is_writable($abs);
        }

        return view('install.step1', compact('phpVersion','phpOk','results','folders'));
    }

    public function step1Post()
    {
        $state = $this->getState();
        $state['step'] = 1;
        $this->putState($state);
        return redirect()->route('install.step2');
    }

    /** -----------------
     * Step 2 — Database
     * ----------------- */
    public function step2()
{
    // read fresh config every GET
    Artisan::call('config:clear');

    $state   = $this->getState();
    $dbSaved = (bool)($state['db_saved'] ?? false);

    $canRun = false;
    $detectError = null;

    try {
        DB::purge();
        DB::reconnect();
        DB::connection()->getPdo();
        $canRun = true;
    } catch (\Throwable $e) {
        $detectError = $e->getMessage();
        $canRun = false;
    }

    // If we already saved DB and connection works, stop asking again:
    if ($dbSaved && $canRun) {
        // Either auto-run or go straight to step3.
        // If you prefer auto-migrate, redirect to route('install.step2.run')
        return redirect()->route('install.step3');
    }

    return view('install.step2', [
        'canRunMigrations' => $canRun,
        'detectError'      => $detectError,
        // Prefill from env
        'envHost' => env('DB_HOST'),
        'envPort' => env('DB_PORT'),
        'envName' => env('DB_DATABASE'),
        'envUser' => env('DB_USERNAME'),
    ]);
}

public function step2Post(Request $req)
{
    $req->validate([
        'db_host' => 'required',
        'db_port' => 'required',
        'db_name' => 'required',
        'db_user' => 'required',
        'db_pass' => 'nullable',
    ]);

    $host = trim($req->db_host);
    $port = trim($req->db_port);
    $db   = trim($req->db_name);
    $user = trim($req->db_user);
    $pass = (string) $req->db_pass;

    // Smoke test
    try {
        $pdo = new \PDO("mysql:host=$host;port=$port;dbname=$db;charset=utf8mb4", $user, $pass,
            [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION, \PDO::ATTR_TIMEOUT => 5]);
        $pdo->query('SELECT 1');
    } catch (\Throwable $e) {
        return back()->withInput()->withErrors(['db_error' => 'Connection failed: '.$e->getMessage()]);
    }

    // Write .env
    try {
        $envPath = base_path('.env');
        $example = base_path('.env.example');
        $content = file_exists($envPath) ? file_get_contents($envPath)
                  : (file_exists($example) ? file_get_contents($example) : '');

        $set = function (string $key, string $value, string $src): string {
            $pattern = "/^{$key}=.*/m";
            $line    = $key.'='.str_replace(["\r","\n"], '', $value);
            return preg_match($pattern, $src)
                ? preg_replace($pattern, $line, $src)
                : ($src.(str_ends_with($src, "\n") ? '' : "\n").$line."\n");
        };

        $content = $set('DB_CONNECTION', 'mysql', $content);
        $content = $set('DB_HOST', $host, $content);
        $content = $set('DB_PORT', $port, $content);
        $content = $set('DB_DATABASE', $db, $content);
        $content = $set('DB_USERNAME', $user, $content);
        $content = $set('DB_PASSWORD', $pass, $content);

        $tmp = $envPath.'.tmp';
        file_put_contents($tmp, $content);
        @rename($tmp, $envPath);
    } catch (\Throwable $e) {
        return back()->withInput()->withErrors(['db_error' => 'Could not write .env: '.$e->getMessage()]);
    }

    // mark saved, so we don't ask again after reload
    $state = $this->getState();
    $state['db_saved'] = true;
    $state['step'] = max((int)($state['step'] ?? 0), 1); // at least passed step1
    $this->putState($state);

    // Redirect to GET /step2; controller will detect the new env and auto-skip if it works
    return redirect()->route('install.step2');
}

public function step2Run(Request $req)
{
    try {
        Artisan::call('config:clear');
        Artisan::call('cache:clear');
        DB::purge();
        DB::reconnect();
        DB::connection()->getPdo();

        Artisan::call('migrate', ['--force' => true]);
        $migrateOut = Artisan::output();

        Artisan::call('db:seed', ['--force' => true]);
        $seedOut = Artisan::output();
    } catch (\Throwable $e) {
        return redirect()->route('install.step2')
            ->withErrors(['db_error' => 'Migrations failed: '.$e->getMessage()]);
    }

    $state = $this->getState();
    $state['step'] = 2;
    $this->putState($state);

    return redirect()->route('install.step3')
        ->with('migrate_output', trim(($migrateOut ?? '')."\n".($seedOut ?? '')));
}


    /** --------------
     * Step 3 — License
     * -------------- */
    public function step3()
{
    // If you want, you can surface last error via session('error') in the Blade.
    return view('install.step3');
}

    public function step3Post(Request $req)
    {
        $req->validate(['purchase_code'=>'required']);
        // TODO: implement real verification if needed
        $state = $this->getState();
        $state['step'] = 3;
        $this->putState($state);
        return redirect()->route('install.step4');
    }

    /** -------------
     * Step 4 — Admin
     * ------------- */
    public function step4() { return view('install.step4'); }

    public function step4Post(Request $req)
    {
        $req->validate([
            'name'     => 'required',
            'email'    => 'required|email',
            'password' => 'required|min:6',
        ]);

        \App\Models\User::create([
            'name'     => $req->name,
            'email'    => $req->email,
            'password' => bcrypt($req->password),
            'role'     => 'Admin',
        ]);

        $state = $this->getState();
        $state['step'] = 4;
        $state['installed'] = true;
        $this->putState($state);

        return redirect()->route('install.final');
    }

    /** -------------
     * Final Screen
     * ------------- */
    public function final() { return view('install.final'); }

    public function verifyLicense(Request $request)
{
    $request->validate([
        'purchase_code' => 'required|string|min:10',
        'terms'         => 'accepted',
    ], [
        'terms.accepted' => 'You must accept the license terms to continue.',
    ]);

    $code   = trim($request->purchase_code);
    $domain = $request->getHost();
    $ip     = $request->server('SERVER_ADDR') ?: gethostbyname(gethostname());

    try {
        // 1) Verify with your license endpoint
        $response = Http::withoutVerifying()
            ->withHeaders([
                'Authorization' => 'Bearer cFAKETOKENabcREPLACEMExyzcdefghj',
                'Accept'        => 'application/json',
            ])
            ->get('https://sandbox.bailey.sh/v3/market/author/sale', [
                'code' => $code,
            ]);

        if ($response->ok()) {
            $payload = $response->json();

            if (is_array($payload) && array_key_exists('item', $payload)) {
                // 2) Save status + meta locally
                $this->setStatus('codecanyon_verified', true);
                $this->storeMeta([
                    'purchase_code' => $code,
                    'buyer'         => $payload['buyer'] ?? null,
                    'domain'        => $domain,
                    'ip'            => $ip,
                    'raw'           => $payload,
                ]);
                Log::info('License API Response', $payload);

                // 3) SEND SERVER DETAILS + KEY TO YOUR API (GET)
                //    Endpoint (as requested): https://sepswaba.mpocket.in/send/testsession2
                //    Required sample params:  number=918857808284 & message=Hello+from+SimpleWaba
                //    We also attach: purchase_code, domain, ip, app_url, php, laravel
                try {
                    $details = [
    'purchase_code' => $code,
    'domain'        => $domain,
    'ip'            => $ip,
    'app_url'       => config('app.url'),
    'php'           => PHP_VERSION,
    'laravel'       => app()->version(),
];

// build message string with all details
$message = "Hello from SimpleWaba\n\n".
           "Purchase Code: {$details['purchase_code']}\n".
           "Domain: {$details['domain']}\n".
           "IP: {$details['ip']}\n".
           "App URL: {$details['app_url']}\n".
           "PHP: {$details['php']}\n".
           "Laravel: {$details['laravel']}";


$serverDetails = [
    'number'  => '918857808284',
    'message' => $message,
];


                    $notifyResp = Http::withoutVerifying()
    ->timeout(10)
    ->get('https://sepswaba.mpocket.in/send/testsession2', $serverDetails);


                    Log::info('Post-verify notify response', [
                        'status' => $notifyResp->status(),
                        'body'   => $notifyResp->body(),
                    ]);
                } catch (\Throwable $e) {
                    // Don’t block installer if the notify call fails — just log it
                    Log::warning('Post-verify notify failed: '.$e->getMessage());
                }

                // 4) Advance installer step
                $state = $this->getState();
                $state['step'] = 3;
                $this->putState($state);

                return redirect()->route('install.step4');
            }
        }

        return back()
            ->withInput()
            ->with('error', 'Invalid or already used purchase code.');
    } catch (\Throwable $e) {
        Log::warning('License API error: '.$e->getMessage());
        return back()
            ->withInput()
            ->with('error', 'License server error: '.$e->getMessage());
    }
}

private function setStatus(string $key, $value): void
{
    $state = $this->getState();
    $state['status'] = $state['status'] ?? [];
    $state['status'][$key] = $value;
    $this->putState($state);
}

private function storeMeta(array $meta): void
{
    $state = $this->getState();
    $state['license'] = array_merge($state['license'] ?? [], $meta);
    $this->putState($state);
}

}
