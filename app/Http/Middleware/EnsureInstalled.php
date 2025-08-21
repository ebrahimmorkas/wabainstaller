<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class EnsureInstalled
{
    public function handle(Request $request, Closure $next)
    {
        $stateFile = storage_path('app/installer/state.json');
        if (!File::exists($stateFile)) {
            return redirect()->route('install.step1');
        }
        $state = json_decode(File::get($stateFile), true);
        if (empty($state['installed'])) {
            return redirect()->route('install.step1');
        }
        return $next($request);
    }
}
