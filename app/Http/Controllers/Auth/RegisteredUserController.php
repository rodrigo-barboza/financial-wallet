<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\Auth\StoreUserRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

final class RegisteredUserController
{
    public function create(): Response
    {
        return Inertia::render('Auth/Register');
    }

    public function store(StoreUserRequest $request): RedirectResponse
    {
        $user = User::create($request->validated());

        Auth::login($user);

        return redirect(route('home', absolute: false));
    }
}
