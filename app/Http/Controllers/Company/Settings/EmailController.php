<?php

namespace App\Http\Controllers\Company\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Company\Settings\Email\UpdateEmailRequest;
use Illuminate\Http\RedirectResponse;
use Inertia\Response;

class EmailController extends Controller
{
    /**
     * Show the email settings page.
     */
    public function index(): Response
    {
        return inertia('Company/Settings/Email', [
            'breadcrumbs' => [
                ['label' => 'Dashboard', 'href' => route('company.dashboard.index')],
                ['label' => 'Account Settings', 'href' => route('company.settings.profile.index')],
                ['label' => 'Email Address'],
            ],
        ]);
    }

    /**
     * Update the company's email address.
     */
    public function update(UpdateEmailRequest $request): RedirectResponse
    {
        auth('company')->user()->update(['email' => $request->string('email')]);

        return back()->with('success', 'Email updated successfully.');
    }
}
