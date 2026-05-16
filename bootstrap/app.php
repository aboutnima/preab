<?php

use App\Http\Middleware\HandleInertiaRequests;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Middleware\AddLinkHeadersForPreloadedAssets;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->web(append: [
            HandleInertiaRequests::class,
            AddLinkHeadersForPreloadedAssets::class,
        ]);

        /**
         * Redirect unauthenticated users to the correct login page based on the requested URL.
         */
        $middleware->redirectGuestsTo(function (Request $request): string {
            if ($request->is('company/*')) {
                return route('company.authentication.login');
            }

            dd('No Route To Go');
        });

        /**
         * Redirect already-authenticated guards away from guest-only pages.
         */
        $middleware->redirectUsersTo(function (Request $request): string {
            if ($request->user('company')) {
                return route('company.dashboard');
            }

            dd('No Route To Go');
        });
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
