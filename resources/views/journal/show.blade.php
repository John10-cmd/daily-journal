@extends('layouts.app', ['title' => $entry->title])

@section('content')
    <article class="mx-auto max-w-4xl">
        <div class="panel">
            <div class="mb-6 flex flex-wrap items-start justify-between gap-4">
                <div>
                    <p class="text-sm text-zinc-500">{{ $entry->entry_date->format('F d, Y') }} · {{ $entry->reading_minutes }} min read</p>
                    <h1 class="mt-2 text-3xl font-bold">{{ $entry->title }}</h1>
                </div>
                <span class="badge">{{ ucfirst($entry->mood) }}</span>
            </div>

            <div class="prose max-w-none whitespace-pre-line text-zinc-700">{{ $entry->body }}</div>

            @if ($entry->tags)
                <div class="mt-6 flex flex-wrap gap-2">
                    @foreach ($entry->tags as $tag)
                        <span class="rounded bg-zinc-100 px-2 py-1 text-xs font-medium text-zinc-600">{{ $tag }}</span>
                    @endforeach
                </div>
            @endif

            <div class="mt-8 flex flex-wrap gap-3">
                <a class="btn btn-secondary" href="{{ route('journal.edit', $entry) }}">Edit</a>
                <a class="btn btn-ghost" href="{{ route('journal.index') }}">Back</a>
                <form method="POST" action="{{ route('journal.destroy', $entry) }}" data-confirm="Delete this entry? This cannot be undone.">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger" type="submit">Delete</button>
                </form>
            </div>
        </div>
    </article>
@endsection
