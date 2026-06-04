@extends('layouts.app', ['title' => 'Create User'])

@section('content')
    <section class="mx-auto max-w-4xl">
        <div class="mb-5">
            <p class="text-sm font-semibold uppercase tracking-wide text-emerald-700">Admin</p>
            <h1 class="text-3xl font-bold">Create User</h1>
        </div>
        <form method="POST" action="{{ route('admin.users.store') }}" class="panel space-y-5">
            @include('admin.users._form', ['button' => 'Create User'])
        </form>
    </section>
@endsection
