<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::updateOrCreate([
            'email' => 'admin@dailyjournal.test',
        ], [
            'name' => 'Daily Journal Admin',
            'password' => 'Admin12345',
            'is_admin' => true,
        ]);
    }
}
