<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function edit(Request $request): View
    {
        return view('profile.edit', ['user' => $request->user()]);
    }

    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();

        $validated = $request->validate(
            [
                'name' => ['required', 'string', 'max:80'],
                'email' => ['required', 'email', 'max:255', 'unique:users,email,'.$user->id],
                'bio' => ['nullable', 'string', 'max:500'],
                'avatar' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            ],
            [
                'name.required' => 'Enter your name.',
                'name.max' => 'Your name cannot be longer than 80 characters.',
                'email.required' => 'Enter your email address.',
                'email.email' => 'Enter a valid email address.',
                'email.unique' => 'Another account already uses this email address.',
                'bio.max' => 'Your bio cannot be longer than 500 characters.',
                'avatar.image' => 'Choose a valid image for your profile photo.',
                'avatar.mimes' => 'Profile photos must be JPG, PNG, or WebP files.',
                'avatar.max' => 'The profile photo must be smaller than 2 MB.',
            ]
        );

        if ($request->hasFile('avatar')) {
            if ($user->avatar_path) {
                Storage::disk('public')->delete($user->avatar_path);
            }

            $validated['avatar_path'] = $request->file('avatar')->store('avatars', 'public');
        }

        unset($validated['avatar']);
        $user->fill($validated)->save();

        return back()->with('success', 'Profile updated.');
    }

    public function updatePassword(Request $request): RedirectResponse
    {
        $validated = $request->validate(
            [
                'current_password' => ['required', 'current_password'],
                'password' => ['required', 'confirmed', Password::min(8)->letters()->numbers()],
            ],
            [
                'current_password.required' => 'Enter your current password.',
                'current_password.current_password' => 'Your current password is incorrect.',
                'password.required' => 'Enter a new password.',
                'password.confirmed' => 'The new password confirmation does not match.',
                'password.min' => 'Your new password must contain at least 8 characters.',
                'password.letters' => 'Your new password must contain at least one letter.',
                'password.numbers' => 'Your new password must contain at least one number.',
            ]
        );

        $request->user()->update([
            'password' => $validated['password'],
        ]);

        return back()->with('success', 'Password updated.');
    }
}
