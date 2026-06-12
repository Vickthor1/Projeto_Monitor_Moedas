<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(LoginRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        if (Auth::attempt(['email' => $validated['email'], 'password' => $validated['password']], $request->boolean('remember'))) {
            $request->session()->regenerate();

            return redirect()->intended(route('dashboard'));
        }

        \Log::warning('Falha de autenticação', [
            'email' => $validated['email'],
            'ip' => $request->ip(),
        ]);

        return back()->withErrors(['email' => 'E-mail ou senha inválidos'])->withInput();
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}

