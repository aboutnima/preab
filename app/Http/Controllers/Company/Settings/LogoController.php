<?php

namespace App\Http\Controllers\Company\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Company\Settings\Logo\StoreLogoRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Inertia\Response;

class LogoController extends Controller
{
    /**
     * Show the logo settings page.
     */
    public function index(): Response
    {
        return inertia('Company/Settings/Logo', [
            'breadcrumbs' => [
                ['label' => 'Dashboard', 'href' => route('company.dashboard.index')],
                ['label' => 'Account Settings', 'href' => route('company.settings.profile.index')],
                ['label' => 'Logo'],
            ],
        ]);
    }

    /**
     * Upload and store the company logo.
     */
    public function store(StoreLogoRequest $request): RedirectResponse
    {
        $company = auth('company')->user();

        if ($company->logo) {
            Storage::disk('public')->delete($company->logo);
        }

        $path = $request->file('logo')->store('logos', 'public');

        $company->update(['logo' => $path]);

        return back()->with('success', 'Logo updated successfully.');
    }

    /**
     * Remove the company logo.
     */
    public function destroy(): RedirectResponse
    {
        $company = auth('company')->user();

        if ($company->logo) {
            Storage::disk('public')->delete($company->logo);
            $company->update(['logo' => null]);
        }

        return back()->with('success', 'Logo removed.');
    }
}
