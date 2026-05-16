<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use Inertia\Response;

class DashboardController extends Controller
{
    /**
     * Show the company dashboard.
     */
    public function index(): Response
    {
        return inertia('Company/Dashboard', [
            'breadcrumbs' => [
                ['label' => 'Dashboard'],
            ],
        ]);
    }
}
