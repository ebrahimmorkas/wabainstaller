<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class EnsureNotInstalled
{
    public function handle(Request $request, Closure $next)
    {
        $stateFile = storage_path('app/installer/state.json');
        if (File::exists($stateFile)) {
            $state = json_decode(File::get($stateFile), true);
            if (!empty($state['installed'])) {
                abort(403, 'ALREADY INSTALLED');
            }
        }
        return $next($request);
    }
}
