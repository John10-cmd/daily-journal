@extends('layouts.app', ['title' => 'Login'])

@section('content')
    <section class="mx-auto max-w-xl">
        <form method="POST" action="{{ route('login.store') }}" class="panel space-y-5">
            @csrf
            <div>
                <p class="text-sm font-semibold uppercase tracking-wide text-emerald-700">Welcome back</p>
                <h1 class="mt-2 text-3xl font-bold">Login to your journal.</h1>
            </div>
            <div>
                <label class="label" for="email">Email</label>
                <input class="input" id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
            </div>
            <div>
                <label class="label" for="password">Password</label>
                <input class="input" id="password" type="password" name="password" required>
            </div>
            <label class="flex items-center gap-2 text-sm text-zinc-600">
                <input class="rounded border-zinc-300 text-emerald-700" type="checkbox" name="remember" value="1">
                Remember me
            </label>
            <button class="btn btn-primary w-full" type="submit">Login</button>
            <p class="mb-0 text-center text-sm text-zinc-600">
                No account yet?
                <a class="fw-bold" href="{{ route('register') }}">Sign up</a>
            </p>
        </form>
    </section>
@endsection
