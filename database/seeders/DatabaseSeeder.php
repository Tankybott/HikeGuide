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
        User::create([
            'nickname' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => 'admin',
            'is_admin' => true,
            'email_verified_at' => now(),
        ]);

        $this->call(SampleDataSeeder::class);
    }
}
