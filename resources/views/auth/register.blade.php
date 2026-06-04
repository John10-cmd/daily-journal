@extends('layouts.app', ['title' => 'Create Account'])

@section('content')
    <section class="mx-auto grid max-w-5xl gap-8 lg:grid-cols-[0.9fr_1.1fr]">
        <div class="space-y-4">
            <p class="text-sm font-semibold uppercase tracking-wide text-emerald-700">Begin</p>
            <h1 class="text-3xl font-bold">Make a private place for your days.</h1>
            <p class="text-zinc-600">Your entries stay connected to your account, with mood tracking, favorites, search, and profile customization.</p>
        </div>

        <form method="POST" action="{{ route('register.store') }}" class="panel space-y-5">
            @csrf
            <div>
                <label class="label" for="name">Name</label>
                <input class="input" id="name" name="name" value="{{ old('name') }}" required autofocus>
            </div>
            <div>
                <label class="label" for="email">Email</label>
                <input class="input" id="email" type="email" name="email" value="{{ old('email') }}" required>
            </div>
            <div class="grid gap-4 sm:grid-cols-2">
                <div>
                    <label class="label" for="password">Password</label>
                    <input class="input" id="password" type="password" name="password" required>
                </div>
                <div>
                    <label class="label" for="password_confirmation">Confirm</label>
                    <input class="input" id="password_confirmation" type="password" name="password_confirmation" required>
                </div>
            </div>
            <button class="btn btn-primary w-full" type="submit">Create Account</button>
            <p class="mb-0 text-center text-sm text-zinc-600">
                Already have an account?
                <a class="fw-bold" href="{{ route('login') }}">Login</a>
            </p>
        </form>
    </section>
@endsection
