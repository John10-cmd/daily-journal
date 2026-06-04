@extends('layouts.app', ['title' => 'Dashboard'])

@section('content')
    <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
        <div>
            <p class="text-sm font-semibold uppercase tracking-wide text-emerald-700">Dashboard</p>
            <h1 class="text-3xl font-bold">Hi, {{ auth()->user()->name }}.</h1>
        </div>
        <a href="{{ route('journal.create') }}" class="btn btn-primary">Write Entry</a>
    </div>

    <section class="grid gap-4 md:grid-cols-3">
        <div class="stat-card">
            <p class="stat-label">Total Entries</p>
            <p class="stat-number">{{ $totalEntries }}</p>
        </div>
        <div class="stat-card">
            <p class="stat-label">Favorites</p>
            <p class="stat-number">{{ $favoriteEntries }}</p>
        </div>
        <div class="stat-card">
            <p class="stat-label">Current Streak</p>
            <p class="stat-number">{{ $currentStreak }} days</p>
        </div>
    </section>

    <section class="mt-6 grid gap-6 lg:grid-cols-[1.1fr_0.9fr]">
        <div class="panel">
            <div class="mb-4 flex items-center justify-between">
                <h2 class="text-xl font-bold">Recent Entries</h2>
                <a href="{{ route('journal.index') }}" class="text-sm font-semibold text-emerald-700">View all</a>
            </div>
            <div class="space-y-3">
                @forelse ($recentEntries as $entry)
                    <a href="{{ route('journal.show', $entry) }}" class="block rounded border border-zinc-200 p-4 transition hover:border-emerald-300 hover:bg-emerald-50/40">
                        <div class="flex items-center justify-between gap-3">
                            <h3 class="font-semibold">{{ $entry->title }}</h3>
                            <span class="badge">{{ ucfirst($entry->mood) }}</span>
                        </div>
                        <p class="mt-2 line-clamp-2 text-sm text-zinc-600">{{ $entry->body }}</p>
                    </a>
                @empty
                    <p class="rounded bg-zinc-50 p-4 text-zinc-600">No entries yet. Start with a few honest lines about today.</p>
                @endforelse
            </div>
        </div>

        <div class="panel">
            <h2 class="mb-4 text-xl font-bold">Mood Mix</h2>
            <div class="space-y-3">
                @forelse ($moodCounts as $mood => $total)
                    <div>
                        <div class="mb-1 flex justify-between text-sm">
                            <span class="font-medium">{{ ucfirst($mood) }}</span>
                            <span>{{ $total }}</span>
                        </div>
                        <div class="h-2 rounded bg-zinc-100">
                            <div class="h-2 rounded bg-emerald-700" style="width: {{ max(12, ($total / max(1, $totalEntries)) * 100) }}%"></div>
                        </div>
                    </div>
                @empty
                    <p class="text-zinc-600">Mood stats appear after your first entry.</p>
                @endforelse
            </div>
        </div>
    </section>
@endsection
