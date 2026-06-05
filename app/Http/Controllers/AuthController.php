<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function createRegister(): View
    {
        return view('auth.register');
    }

    public function storeRegister(Request $request): RedirectResponse
    {
        $validated = $request->validate(
            [
                'name' => ['required', 'string', 'max:80'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
                'password' => ['required', 'confirmed', Password::min(8)->letters()->numbers()],
            ],
            [
                'name.required' => 'Enter your name.',
                'name.max' => 'Your name cannot be longer than 80 characters.',
                'email.required' => 'Enter your email address.',
                'email.email' => 'Enter a valid email address.',
                'email.unique' => 'An account already uses this email address.',
                'password.required' => 'Create a password.',
                'password.confirmed' => 'The password confirmation does not match.',
                'password.min' => 'Your password must contain at least 8 characters.',
                'password.letters' => 'Your password must contain at least one letter.',
                'password.numbers' => 'Your password must contain at least one number.',
            ]
        );

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        Auth::login($user);

        return redirect()->route('dashboard')->with('success', 'Your account was created successfully.');
    }

    public function createLogin(): View
    {
        return view('auth.login');
    }

    public function storeLogin(Request $request): RedirectResponse
    {
        $credentials = $request->validate(
            [
                'email' => ['required', 'email'],
                'password' => ['required', 'string'],
            ],
            [
                'email.required' => 'Enter your email address.',
                'email.email' => 'Enter a valid email address.',
                'password.required' => 'Enter your password.',
            ]
        );

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()->withErrors([
                'email' => 'The email address or password is incorrect.',
            ])->onlyInput('email');
        }

        $request->session()->regenerate();

        return redirect()->intended(route('dashboard'))->with('success', 'You are now logged in.');
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'You are now logged out.');
    }
}
