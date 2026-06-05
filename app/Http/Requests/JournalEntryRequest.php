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

    public function messages(): array
    {
        return [
            'title.required' => 'Enter a title for your journal entry.',
            'title.max' => 'The title cannot be longer than 120 characters.',
            'body.required' => 'Write something before saving the entry.',
            'body.min' => 'Your journal entry must contain at least 10 characters.',
            'mood.required' => 'Select a mood for this entry.',
            'mood.in' => 'Select one of the available moods.',
            'entry_date.required' => 'Select a date for this entry.',
            'entry_date.date' => 'Enter a valid entry date.',
            'entry_date.before_or_equal' => 'The entry date cannot be in the future.',
            'tags.max' => 'Tags cannot be longer than 160 characters.',
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
