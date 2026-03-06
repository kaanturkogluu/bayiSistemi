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
        \App\Models\Account::create([
            'username' => 'bayi1',
            'password' => bcrypt('password'),
            'role' => 'bayi',
        ]);

        \App\Models\Account::create([
            'username' => 'usta1',
            'password' => bcrypt('password'),
            'role' => 'usta',
        ]);
    }
}
