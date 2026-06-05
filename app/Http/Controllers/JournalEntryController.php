<?php

namespace App\Http\Controllers;

use App\Http\Requests\JournalEntryRequest;
use App\Models\JournalEntry;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class JournalEntryController extends Controller
{
    public function index(Request $request): View
    {
        $entries = $request->user()->journalEntries()
            ->forSearch($request->string('search')->toString())
            ->when($request->filled('mood'), fn ($query) => $query->where('mood', $request->mood))
            ->when($request->boolean('favorites'), fn ($query) => $query->where('is_favorite', true))
            ->latest('entry_date')
            ->latest()
            ->paginate(8)
            ->withQueryString();

        return view('journal.index', [
            'entries' => $entries,
            'moods' => JournalEntryRequest::moods(),
        ]);
    }

    public function create(): View
    {
        return view('journal.create', [
            'entry' => new JournalEntry(['entry_date' => now()]),
            'moods' => JournalEntryRequest::moods(),
        ]);
    }

    public function store(JournalEntryRequest $request): RedirectResponse
    {
        $request->user()->journalEntries()->create($request->payload());

        return redirect()->route('journal.index')->with('success', 'Your journal entry was saved.');
    }

    public function show(JournalEntry $journal): View
    {
        $this->authorizeEntry($journal);

        return view('journal.show', ['entry' => $journal]);
    }

    public function edit(JournalEntry $journal): View
    {
        $this->authorizeEntry($journal);

        return view('journal.edit', [
            'entry' => $journal,
            'moods' => JournalEntryRequest::moods(),
        ]);
    }

    public function update(JournalEntryRequest $request, JournalEntry $journal): RedirectResponse
    {
        $this->authorizeEntry($journal);
        $journal->update($request->payload());

        return redirect()->route('journal.show', $journal)->with('success', 'Your journal entry was updated.');
    }

    public function destroy(JournalEntry $journal): RedirectResponse
    {
        $this->authorizeEntry($journal);
        $journal->delete();

        return redirect()->route('journal.index')->with('success', 'Your journal entry was deleted.');
    }

    private function authorizeEntry(JournalEntry $entry): void
    {
        abort_unless($entry->user_id === auth()->id(), 403);
    }
}
