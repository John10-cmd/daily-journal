<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class UserManagementController extends Controller
{
    public function index(Request $request): View
    {
        $this->authorizeAdmin();

        $users = User::query()
            ->withCount('journalEntries')
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->string('search')->toString();

                $query->where(function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.users.index', ['users' => $users]);
    }

    public function create(): View
    {
        $this->authorizeAdmin();

        return view('admin.users.create', ['user' => new User()]);
    }

    public function store(Request $request): RedirectResponse
    {
        $this->authorizeAdmin();

        $validated = $request->validate(
            [
                'name' => ['required', 'string', 'max:80'],
                'email' => ['required', 'email', 'max:255', 'unique:users,email'],
                'bio' => ['nullable', 'string', 'max:500'],
                'is_admin' => ['nullable', 'boolean'],
                'password' => ['required', 'confirmed', Password::min(8)->letters()->numbers()],
            ],
            $this->validationMessages()
        );

        $validated['is_admin'] = $request->boolean('is_admin');

        User::create($validated);

        return redirect()->route('admin.users.index')->with('success', 'The user account was created.');
    }

    public function edit(User $user): View
    {
        $this->authorizeAdmin();

        return view('admin.users.edit', ['user' => $user]);
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $this->authorizeAdmin();

        $validated = $request->validate(
            [
                'name' => ['required', 'string', 'max:80'],
                'email' => ['required', 'email', 'max:255', 'unique:users,email,'.$user->id],
                'bio' => ['nullable', 'string', 'max:500'],
                'is_admin' => ['nullable', 'boolean'],
                'password' => ['nullable', 'confirmed', Password::min(8)->letters()->numbers()],
            ],
            $this->validationMessages()
        );

        $validated['is_admin'] = $request->boolean('is_admin');

        if (empty($validated['password'])) {
            unset($validated['password']);
        }

        if ($user->is(auth()->user())) {
            $validated['is_admin'] = true;
        }

        $user->update($validated);

        return redirect()->route('admin.users.index')->with('success', 'The user account was updated.');
    }

    public function destroy(User $user): RedirectResponse
    {
        $this->authorizeAdmin();

        if ($user->is(auth()->user())) {
            return back()->withErrors(['user' => 'You cannot delete your own admin account.']);
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'The user account was deleted.');
    }

    private function authorizeAdmin(): void
    {
        abort_unless(auth()->check() && auth()->user()->is_admin, 403);
    }

    private function validationMessages(): array
    {
        return [
            'name.required' => 'Enter the user\'s name.',
            'name.max' => 'The user\'s name cannot be longer than 80 characters.',
            'email.required' => 'Enter the user\'s email address.',
            'email.email' => 'Enter a valid email address for the user.',
            'email.unique' => 'Another account already uses this email address.',
            'bio.max' => 'The user bio cannot be longer than 500 characters.',
            'password.required' => 'Create a password for the user.',
            'password.confirmed' => 'The password confirmation does not match.',
            'password.min' => 'The password must contain at least 8 characters.',
            'password.letters' => 'The password must contain at least one letter.',
            'password.numbers' => 'The password must contain at least one number.',
        ];
    }
}
