@csrf
<div class="grid gap-4 sm:grid-cols-2">
    <div>
        <label class="label" for="title">Title</label>
        <input class="input" id="title" name="title" value="{{ old('title', $entry->title) }}" required maxlength="120">
    </div>
    <div>
        <label class="label" for="entry_date">Date</label>
        <input class="input" id="entry_date" type="date" name="entry_date" value="{{ old('entry_date', optional($entry->entry_date)->format('Y-m-d') ?? now()->format('Y-m-d')) }}" max="{{ now()->format('Y-m-d') }}" required>
    </div>
</div>

<div>
    <label class="label">Mood</label>
    <div class="grid gap-2 sm:grid-cols-3" data-mood-picker>
        @foreach ($moods as $value => $label)
            <label class="mood-option {{ old('mood', $entry->mood) === $value ? 'is-selected' : '' }}">
                <input class="sr-only" type="radio" name="mood" value="{{ $value }}" @checked(old('mood', $entry->mood) === $value) required>
                {{ $label }}
            </label>
        @endforeach
    </div>
</div>

<div>
    <label class="label" for="body">Entry</label>
    <textarea class="input min-h-64" id="body" name="body" required>{{ old('body', $entry->body) }}</textarea>
</div>

<div class="grid gap-4 sm:grid-cols-[1fr_auto] sm:items-end">
    <div>
        <label class="label" for="tags">Tags</label>
        <input class="input" id="tags" name="tags" value="{{ old('tags', implode(', ', $entry->tags ?? [])) }}" placeholder="work, family, gratitude">
    </div>
    <label class="flex items-center gap-2 rounded border border-zinc-200 px-4 py-3 text-sm font-semibold">
        <input type="checkbox" name="is_favorite" value="1" @checked(old('is_favorite', $entry->is_favorite))>
        Favorite
    </label>
</div>

<div class="flex flex-wrap gap-3">
    <button class="btn btn-primary" type="submit">{{ $button ?? 'Save Entry' }}</button>
    <a class="btn btn-secondary" href="{{ route('journal.index') }}">Cancel</a>
</div>
