<?php

namespace App\Http\Controllers\Company\Authentication;

use App\Http\Controllers\Controller;
use App\Http\Requests\Company\Authentication\Register\StoreRegisterRequest;
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
     * TODO: Implement registration logic.
     */
    public function store(StoreRegisterRequest $request): void
    {
        //
    }
}
