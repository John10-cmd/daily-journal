@extends('layouts.app', ['title' => 'Journal Entries'])

@section('content')
    <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
        <div>
            <p class="text-sm font-semibold uppercase tracking-wide text-emerald-700">Entries</p>
            <h1 class="text-3xl font-bold">Your journal library.</h1>
        </div>
        <a href="{{ route('journal.create') }}" class="btn btn-primary">New Entry</a>
    </div>

    <form class="panel mb-5 grid gap-3 md:grid-cols-[1fr_180px_auto_auto]" method="GET" action="{{ route('journal.index') }}">
        <input class="input" name="search" value="{{ request('search') }}" placeholder="Search title, mood, or entry text">
        <select class="input" name="mood">
            <option value="">All moods</option>
            @foreach ($moods as $value => $label)
                <option value="{{ $value }}" @selected(request('mood') === $value)>{{ $label }}</option>
            @endforeach
        </select>
        <label class="flex items-center gap-2 rounded border border-zinc-200 px-4 py-3 text-sm font-semibold">
            <input type="checkbox" name="favorites" value="1" @checked(request()->boolean('favorites'))>
            Favorites
        </label>
        <button class="btn btn-secondary" type="submit">Filter</button>
    </form>

    <section class="grid gap-4 md:grid-cols-2">
        @forelse ($entries as $entry)
            <article class="panel flex flex-col justify-between gap-4">
                <div>
                    <div class="mb-3 flex items-start justify-between gap-3">
                        <div>
                            <p class="text-sm text-zinc-500">{{ $entry->entry_date->format('M d, Y') }} · {{ $entry->reading_minutes }} min read</p>
                            <h2 class="mt-1 text-xl font-bold">{{ $entry->title }}</h2>
                        </div>
                        <span class="badge">{{ ucfirst($entry->mood) }}</span>
                    </div>
                    <p class="line-clamp-3 text-zinc-600">{{ $entry->body }}</p>
                    @if ($entry->tags)
                        <div class="mt-4 flex flex-wrap gap-2">
                            @foreach ($entry->tags as $tag)
                                <span class="rounded bg-zinc-100 px-2 py-1 text-xs font-medium text-zinc-600">{{ $tag }}</span>
                            @endforeach
                        </div>
                    @endif
                </div>
                <div class="flex flex-wrap gap-2">
                    <a class="btn btn-secondary" href="{{ route('journal.show', $entry) }}">Read</a>
                    <a class="btn btn-ghost" href="{{ route('journal.edit', $entry) }}">Edit</a>
                </div>
            </article>
        @empty
            <div class="panel md:col-span-2">
                <h2 class="text-xl font-bold">No matching entries.</h2>
                <p class="mt-2 text-zinc-600">Try clearing the filters or write your first entry.</p>
            </div>
        @endforelse
    </section>

    <div class="mt-6">
        {{ $entries->links() }}
    </div>
@endsection
