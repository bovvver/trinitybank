<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\SessionService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;
use App\Services\AccountCreationService;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request, AccountCreationService $accountService): RedirectResponse
    {
        $accountService->basicInfoValidation($request);
        $accountService->personalInfoValidation($request);
        $accountService->bankProductSelectionValidation($request);

        $user = $accountService->createUserWithAccount($request);
        
        event(new Registered($user));
        
        Auth::login($user);
        
        SessionService::setDefaultAccount($request);

        return redirect(route('dashboard', absolute: false));
    }
}