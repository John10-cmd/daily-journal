@extends('layouts.app', ['title' => 'New Entry'])

@section('content')
    <section class="mx-auto max-w-4xl">
        <div class="mb-5">
            <p class="text-sm font-semibold uppercase tracking-wide text-emerald-700">New entry</p>
            <h1 class="text-3xl font-bold">What needs a little room today?</h1>
        </div>
        <form method="POST" action="{{ route('journal.store') }}" class="panel space-y-5">
            @include('journal._form', ['button' => 'Save Entry'])
        </form>
    </section>
@endsection
