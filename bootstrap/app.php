<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        // Ini memastikan routes/web.php dimuat
        web: __DIR__.'/../routes/web.php', 
        // Ini memastikan routes/api.php dimuat
        api: __DIR__.'/../routes/api.php', 
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // ...
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // ...
    })->create();