<?php

use App\Http\Controllers\Company;
use Illuminate\Support\Facades\Route;

Route::prefix('company')->name('company.')->group(function (): void {
    Route::middleware('auth:company')->group(function (): void {
        Route::get('dashboard', [Company\DashboardController::class, 'index'])->name('dashboard.index');

        Route::prefix('settings')->name('settings.')->group(function (): void {
            Route::redirect('/', '/company/settings/profile');

            Route::prefix('profile')->name('profile.')->controller(Company\Settings\ProfileController::class)->group(function (): void {
                Route::get('/', 'index')->name('index');
                Route::patch('/', 'update')->name('update');
            });

            Route::prefix('logo')->name('logo.')->controller(Company\Settings\LogoController::class)->group(function (): void {
                Route::get('/', 'index')->name('index');
                Route::post('/', 'store')->name('store');
                Route::delete('/', 'destroy')->name('destroy');
            });

            Route::prefix('email')->name('email.')->controller(Company\Settings\EmailController::class)->group(function (): void {
                Route::get('/', 'index')->name('index');
                Route::patch('/', 'update')->name('update');
            });

            Route::prefix('password')->name('password.')->controller(Company\Settings\PasswordController::class)->group(function (): void {
                Route::get('/', 'index')->name('index');
                Route::patch('/', 'update')->name('update');
            });
        });
    });

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
