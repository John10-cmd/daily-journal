@csrf

<div class="grid gap-4 sm:grid-cols-2">
    <div>
        <label class="label" for="name">Name</label>
        <input class="input" id="name" name="name" value="{{ old('name', $user->name) }}" required>
    </div>
    <div>
        <label class="label" for="email">Email</label>
        <input class="input" id="email" type="email" name="email" value="{{ old('email', $user->email) }}" required>
    </div>
</div>

<div>
    <label class="label" for="bio">Bio</label>
    <textarea class="input min-h-24" id="bio" name="bio">{{ old('bio', $user->bio) }}</textarea>
</div>

<div class="grid gap-4 sm:grid-cols-2">
    <div>
        <label class="label" for="password">{{ $user->exists ? 'New Password' : 'Password' }}</label>
        <input class="input" id="password" type="password" name="password" @required(! $user->exists)>
    </div>
    <div>
        <label class="label" for="password_confirmation">Confirm Password</label>
        <input class="input" id="password_confirmation" type="password" name="password_confirmation" @required(! $user->exists)>
    </div>
</div>

<label class="flex items-center gap-2 rounded border border-zinc-200 px-4 py-3 text-sm font-semibold">
    <input type="checkbox" name="is_admin" value="1" @checked(old('is_admin', $user->is_admin))>
    Admin account
</label>

<div class="flex flex-wrap gap-3">
    <button class="btn btn-primary" type="submit">{{ $button ?? 'Save User' }}</button>
    <a class="btn btn-secondary" href="{{ route('admin.users.index') }}">Cancel</a>
</div>
