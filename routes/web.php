<?php

use App\Http\Controllers\Company;
use Illuminate\Support\Facades\Route;

Route::prefix('company')->name('company.')->group(function (): void {
    Route::prefix('authentication')->name('authentication.')->group(function (): void {
        Route::middleware('guest:company')->group(function (): void {
            Route::controller(Company\Authentication\LoginController::class)->group(function (): void {
                Route::get('login', 'index')->name('login');
                Route::post('login', 'store')->name('store');
            });

            Route::controller(Company\Authentication\RegisterController::class)->group(function (): void {
                Route::get('register', 'index')->name('register');
                Route::post('register', 'store')->name('store');
            });
        });

        Route::middleware('auth:company')->group(function (): void {
            Route::post('logout', [Company\Authentication\LogoutController::class, 'store'])->name('logout');
        });
    });
});
