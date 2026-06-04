@extends('layouts.app', ['title' => 'Profile'])

@section('content')
    <section class="grid gap-6 lg:grid-cols-[0.8fr_1.2fr]">
        <div class="panel h-fit space-y-4">
            <img src="{{ $user->avatar_url }}" alt="Profile photo" class="h-28 w-28 rounded-full object-cover">
            <div>
                <h1 class="text-2xl font-bold">{{ $user->name }}</h1>
                <p class="text-sm text-zinc-500">{{ $user->email }}</p>
            </div>
            <p class="text-zinc-600">{{ $user->bio ?: 'Add a short note about what this journal helps you notice.' }}</p>
        </div>

        <div class="space-y-6">
            <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="panel space-y-5">
                @csrf
                @method('PUT')

                <div>
                    <p class="text-sm font-semibold uppercase tracking-wide text-emerald-700">Profile details</p>
                    <h2 class="mt-1 text-2xl font-bold">Your public journal identity</h2>
                </div>

                <div>
                    <span class="label">Profile Image</span>
                    <label class="avatar-picker group" for="avatar">
                        <img id="avatar-preview" src="{{ $user->avatar_url }}" alt="Profile photo preview">
                        <span class="avatar-picker-overlay" aria-hidden="true">
                            <svg class="h-7 w-7" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 20h9" />
                                <path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4Z" />
                            </svg>
                        </span>
                    </label>
                    <input class="sr-only" id="avatar" type="file" name="avatar" accept="image/*" data-preview="avatar-preview">
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label class="label" for="name">Name</label>
                        <input class="input" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                    </div>
                    <div>
                        <label class="label" for="email">Email</label>
                        <input class="input" id="email" type="email" name="email" value="{{ old('email', $user->email) }}" required>
                    </div>
                </div>

                <div>
                    <label class="label" for="bio">Bio</label>
                    <textarea class="input min-h-28" id="bio" name="bio">{{ old('bio', $user->bio) }}</textarea>
                </div>

                <button class="btn btn-primary" type="submit">Save Profile</button>
            </form>

            <form method="POST" action="{{ route('profile.password.update') }}" class="panel space-y-5">
                @csrf
                @method('PUT')

                <div>
                    <p class="text-sm font-semibold uppercase tracking-wide text-emerald-700">Security</p>
                    <h2 class="mt-1 text-2xl font-bold">Change password</h2>
                </div>

                <div>
                    <label class="label" for="current_password">Current Password</label>
                    <input class="input" id="current_password" type="password" name="current_password" required autocomplete="current-password">
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label class="label" for="password">New Password</label>
                        <input class="input" id="password" type="password" name="password" required autocomplete="new-password">
                    </div>
                    <div>
                        <label class="label" for="password_confirmation">Confirm Password</label>
                        <input class="input" id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password">
                    </div>
                </div>

                <button class="btn btn-secondary" type="submit">Update Password</button>
            </form>
        </div>
    </section>
@endsection
