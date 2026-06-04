@extends('layouts.app', ['title' => 'Daily Journal'])

@section('content')
    <section class="grid min-h-[72vh] items-center">
        <div class="space-y-7">
            <div class="inline-flex rounded-full border border-emerald-200 bg-white px-4 py-2 text-sm font-medium text-emerald-800">
                Private daily writing, built with Laravel
            </div>
            <div class="space-y-4">
                <h1 class="max-w-2xl text-4xl font-bold leading-tight text-zinc-950 sm:text-6xl">Daily Journal</h1>
                <p class="max-w-xl text-lg leading-8 text-zinc-600">
                    Capture your day, track your mood, revisit meaningful entries, and keep your thoughts organized in a calm private workspace.
                </p>
            </div>
            <div class="flex flex-wrap gap-3">
                @auth
                    <a href="{{ route('dashboard') }}" class="btn btn-primary">Open Dashboard</a>
                    <a href="{{ route('journal.create') }}" class="btn btn-secondary">Write Today</a>
                @else
                    <a href="{{ route('register') }}" class="btn btn-primary">Create Account</a>
                    <a href="{{ route('login') }}" class="btn btn-secondary">Login</a>
                @endauth
            </div>
        </div>
    </section>
@endsection
