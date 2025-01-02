<?php

use App\Http\Middleware\VerifyCsrfToken;
use App\Models\EnvironmentVariable;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\DB;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {

        $middleware->validateCsrfTokens(
            except: ['csrf/*']
        );

    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
