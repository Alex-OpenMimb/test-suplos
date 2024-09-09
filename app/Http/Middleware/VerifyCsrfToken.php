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
        '/tasks',
        'task/complete/1',
        'task/complete/2',
        'task/complete/3',
        'task/complete/4',
        '/task/1',
        '/task/2',
        '/task/3',
        '/task/4',
        '/task/5',
    ];

}
