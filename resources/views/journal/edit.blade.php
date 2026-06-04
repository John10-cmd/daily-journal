@extends('layouts.app', ['title' => 'Edit Entry'])

@section('content')
    <section class="mx-auto max-w-4xl">
        <div class="mb-5">
            <p class="text-sm font-semibold uppercase tracking-wide text-emerald-700">Edit entry</p>
            <h1 class="text-3xl font-bold">{{ $entry->title }}</h1>
        </div>
        <form method="POST" action="{{ route('journal.update', $entry) }}" class="panel space-y-5">
            @method('PUT')
            @include('journal._form', ['button' => 'Update Entry'])
        </form>
    </section>
@endsection
