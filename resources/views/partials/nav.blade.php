<header class="border-b border-zinc-200 bg-white/90 backdrop-blur">
    <nav class="mx-auto flex max-w-6xl items-center justify-between gap-4 px-4 py-4 sm:px-6 lg:px-8">
        <a href="{{ route('home') }}" class="flex items-center gap-3 font-semibold">
            <span class="grid h-10 w-10 place-items-center rounded bg-emerald-700 text-white">DJ</span>
            <span>Daily Journal</span>
        </a>

        <div class="flex items-center gap-2">
            @auth
                <a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a>
                <a class="nav-link" href="{{ route('journal.index') }}">Entries</a>
                @if (auth()->user()->is_admin)
                    <a class="nav-link" href="{{ route('admin.users.index') }}">Users</a>
                @endif
                <a class="nav-link" href="{{ route('profile.edit') }}">
                    <img src="{{ auth()->user()->avatar_url }}" alt="" class="h-8 w-8 rounded-full object-cover">
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="btn btn-ghost" type="submit">Logout</button>
                </form>
            @else
                <a class="nav-link" href="{{ route('login') }}">Login</a>
                <a class="btn btn-primary" href="{{ route('register') }}">Start Writing</a>
            @endauth
        </div>
    </nav>
</header>
