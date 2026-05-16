<?php

namespace App\Http\Controllers\Company\Authentication;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class LogoutController extends Controller
{
    /**
     * Log the company out and redirect to the login page.
     */
    public function store(Request $request): RedirectResponse
    {
        auth('company')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('company.authentication.login');
    }
}
