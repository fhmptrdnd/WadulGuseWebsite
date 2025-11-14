<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Closure;
use Illuminate\Support\Facades\Auth;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    public function handle($request, Closure $next, ...$guards)
    {
        $this->authenticate($request, $guards);
        return $next($request);
    }

    protected function redirectTo(Request $request): ?string
    {
        if (! $request->expectsJson()) {
            session()->flash('error', 'Silahkan login terlebih dahulu untuk mengakses Dashboard le!');

            return '/';
        }
        return null;
    }
}
