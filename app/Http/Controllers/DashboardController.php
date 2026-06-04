<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(Request $request): View
    {
        $entries = $request->user()->journalEntries();

        return view('dashboard.index', [
            'totalEntries' => (clone $entries)->count(),
            'favoriteEntries' => (clone $entries)->where('is_favorite', true)->count(),
            'currentStreak' => $this->streakFor($request),
            'recentEntries' => (clone $entries)->latest('entry_date')->latest()->take(4)->get(),
            'moodCounts' => (clone $entries)
                ->selectRaw('mood, count(*) as total')
                ->groupBy('mood')
                ->orderByDesc('total')
                ->pluck('total', 'mood'),
        ]);
    }

    private function streakFor(Request $request): int
    {
        $dates = $request->user()->journalEntries()
            ->select('entry_date')
            ->distinct()
            ->orderByDesc('entry_date')
            ->pluck('entry_date')
            ->map(fn ($date) => $date->toDateString());

        $streak = 0;
        $cursor = now()->toDateString();

        foreach ($dates as $date) {
            if ($date !== $cursor) {
                if ($streak === 0 && $date === now()->subDay()->toDateString()) {
                    $cursor = now()->subDay()->toDateString();
                } else {
                    break;
                }
            }

            $streak++;
            $cursor = Carbon::parse($cursor)->subDay()->toDateString();
        }

        return $streak;
    }
}
