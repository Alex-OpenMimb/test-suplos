<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [

    ];
    public function handle($request, Closure $next)
    {
        // Agrega logging para depurar el token CSRF
        Log::info('CSRF Token:', ['token' => $request->header('X-CSRF-TOKEN')]);

        return parent::handle($request, $next);
    }
}
