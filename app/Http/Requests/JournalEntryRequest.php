<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class JournalEntryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:120'],
            'body' => ['required', 'string', 'min:10'],
            'mood' => ['required', Rule::in(array_keys(self::moods()))],
            'entry_date' => ['required', 'date', 'before_or_equal:today'],
            'is_favorite' => ['nullable', 'boolean'],
            'tags' => ['nullable', 'string', 'max:160'],
        ];
    }

    public function payload(): array
    {
        $validated = $this->validated();
        $validated['is_favorite'] = $this->boolean('is_favorite');
        $validated['tags'] = collect(explode(',', $validated['tags'] ?? ''))
            ->map(fn ($tag) => trim($tag))
            ->filter()
            ->unique()
            ->values()
            ->all();

        return $validated;
    }

    public static function moods(): array
    {
        return [
            'calm' => 'Calm',
            'happy' => 'Happy',
            'focused' => 'Focused',
            'tired' => 'Tired',
            'anxious' => 'Anxious',
            'grateful' => 'Grateful',
        ];
    }
}
