<?php

namespace App\Http\Controllers\Company\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Company\Settings\Password\UpdatePasswordRequest;
use Illuminate\Http\RedirectResponse;
use Inertia\Response;

class PasswordController extends Controller
{
    /**
     * Show the password settings page.
     */
    public function index(): Response
    {
        return inertia('Company/Settings/Password', [
            'breadcrumbs' => [
                ['label' => 'Dashboard', 'href' => route('company.dashboard.index')],
                ['label' => 'Account Settings', 'href' => route('company.settings.profile.index')],
                ['label' => 'Password'],
            ],
        ]);
    }

    /**
     * Update the company's password.
     */
    public function update(UpdatePasswordRequest $request): RedirectResponse
    {
        auth('company')->user()->update(['password' => $request->string('password')]);

        return back()->with('success', 'Password updated successfully.');
    }
}
