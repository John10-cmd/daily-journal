@extends('layouts.app', ['title' => 'Edit User'])

@section('content')
    <section class="mx-auto max-w-4xl">
        <div class="mb-5">
            <p class="text-sm font-semibold uppercase tracking-wide text-emerald-700">Admin</p>
            <h1 class="text-3xl font-bold">Edit {{ $user->name }}</h1>
        </div>
        <form method="POST" action="{{ route('admin.users.update', $user) }}" class="panel space-y-5">
            @method('PUT')
            @include('admin.users._form', ['button' => 'Update User'])
        </form>
    </section>
@endsection
