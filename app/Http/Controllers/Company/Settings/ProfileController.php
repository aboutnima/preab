<?php

namespace App\Http\Controllers\Company\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Company\Settings\Profile\UpdateProfileRequest;
use Illuminate\Http\RedirectResponse;
use Inertia\Response;

class ProfileController extends Controller
{
    /**
     * Show the account settings page.
     */
    public function index(): Response
    {
        return inertia('Company/Settings/Profile', [
            'breadcrumbs' => [
                ['label' => 'Dashboard', 'href' => route('company.dashboard.index')],
                ['label' => 'Account Settings', 'href' => route('company.settings.profile.index')],
                ['label' => 'Profile'],
            ],
        ]);
    }

    /**
     * Update the company's profile information.
     */
    public function update(UpdateProfileRequest $request): RedirectResponse
    {
        auth('company')->user()->update($request->only('name', 'phone', 'address'));

        return back()->with('success', 'Profile updated successfully.');
    }
}
