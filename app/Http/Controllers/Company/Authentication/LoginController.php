<?php

namespace App\Http\Controllers\Company\Authentication;

use App\Http\Controllers\Controller;
use App\Http\Requests\Company\Authentication\Login\StoreLoginRequest;
use Illuminate\Http\RedirectResponse;
use Inertia\Response;

class LoginController extends Controller
{
    /**
     * Show the company login page.
     */
    public function index(): Response
    {
        return inertia('Company/Authentication/Login');
    }

    /**
     * Handle company login attempt.
     */
    public function store(StoreLoginRequest $request): RedirectResponse
    {
        if (! auth('company')->attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            return back()->withErrors([
                'email' => __('auth.failed'),
            ])->onlyInput('email');
        }

        $request->session()->regenerate();

        return redirect()->intended(route('company.dashboard.index'));
    }
}
