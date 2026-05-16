<?php

namespace App\Http\Controllers\Company\Authentication;

use App\Http\Controllers\Controller;
use App\Http\Requests\Company\Authentication\Register\StoreRegisterRequest;
use App\Models\Company;
use Illuminate\Http\RedirectResponse;
use Inertia\Response;

class RegisterController extends Controller
{
    /**
     * Show the company registration page.
     */
    public function index(): Response
    {
        return inertia('Company/Authentication/Register');
    }

    /**
     * Handle company registration.
     */
    public function store(StoreRegisterRequest $request): RedirectResponse
    {
        $company = Company::create([
            'name' => $request->string('name'),
            'email' => $request->string('email'),
            'password' => $request->string('password'),
        ]);

        auth('company')->login($company);

        $request->session()->regenerate();

        return redirect()->intended(route('company.dashboard.index'));
    }
}
