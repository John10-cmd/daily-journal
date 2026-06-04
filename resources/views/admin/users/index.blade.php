@extends('layouts.app', ['title' => 'User Management'])

@section('content')
    <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
        <div>
            <p class="text-sm font-semibold uppercase tracking-wide text-emerald-700">Admin</p>
            <h1 class="text-3xl font-bold">User Management</h1>
        </div>
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary">New User</a>
    </div>

    <form class="panel mb-5 grid gap-3 sm:grid-cols-[1fr_auto]" method="GET" action="{{ route('admin.users.index') }}">
        <input class="input" name="search" value="{{ request('search') }}" placeholder="Search users by name or email">
        <button class="btn btn-secondary" type="submit">Search</button>
    </form>

    <section class="panel overflow-x-auto">
        <table class="w-full min-w-[720px] text-left text-sm">
            <thead class="border-b border-zinc-200 text-xs uppercase tracking-wide text-zinc-500">
                <tr>
                    <th class="py-3 pr-4">User</th>
                    <th class="py-3 pr-4">Role</th>
                    <th class="py-3 pr-4">Entries</th>
                    <th class="py-3 pr-4">Joined</th>
                    <th class="py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-zinc-100">
                @forelse ($users as $user)
                    <tr>
                        <td class="py-4 pr-4">
                            <div class="flex items-center gap-3">
                                <img src="{{ $user->avatar_url }}" alt="" class="h-10 w-10 rounded-full object-cover">
                                <div>
                                    <p class="font-semibold">{{ $user->name }}</p>
                                    <p class="text-zinc-500">{{ $user->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="py-4 pr-4">
                            <span class="badge">{{ $user->is_admin ? 'Admin' : 'Writer' }}</span>
                        </td>
                        <td class="py-4 pr-4">{{ $user->journal_entries_count }}</td>
                        <td class="py-4 pr-4">{{ $user->created_at->format('M d, Y') }}</td>
                        <td class="py-4 text-right">
                            <div class="flex justify-end gap-2">
                                <a class="btn btn-ghost" href="{{ route('admin.users.edit', $user) }}">Edit</a>
                                <form method="POST" action="{{ route('admin.users.destroy', $user) }}" data-confirm="Delete this user and all journal entries?">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger" type="submit" @disabled($user->is(auth()->user()))>Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td class="py-6 text-zinc-600" colspan="5">No users found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </section>

    <div class="mt-6">
        {{ $users->links() }}
    </div>
@endsection
