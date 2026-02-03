<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create(
            [
                'name' => 'Alex',
                'email' => 'alex@yahoo.com',
                'password' => '111111'
            ]

        );
        User::factory(10)->create();
        $this->call(FilmsSeeder::class);
    }
}
