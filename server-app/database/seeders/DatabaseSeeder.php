<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\CategoryIncidentSeeder;
use Database\Seeders\CategoryRequestServiceSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            CategoryIncidentSeeder::class,
            CategoryRequestServiceSeeder::class,
        ]);
    }
}
