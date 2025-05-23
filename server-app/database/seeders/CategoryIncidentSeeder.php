<?php

namespace Database\Seeders;

use App\Models\CategoryIncident;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoryIncidentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'App Not Responding'],
            ['name' => 'Slow Network Connection'],
            ['name' => 'Password Reset Request'],
            ['name' => 'Data Entry Error'],
            ['name' => 'Feature Request'],
        ];

        foreach ($categories as $category) {
            CategoryIncident::create($category);
        }
    }
}
