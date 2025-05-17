<?php

namespace Database\Seeders;

use App\Models\CategoryProblem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoryProblemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Network Connectivity Issue'],
            ['name' => 'Application Crash/Error'],
            ['name' => 'Slow System Performance'],
            ['name' => 'Login or Authentication Failure'],
            ['name' => 'Data Sync Problem'],
        ];

        foreach ($categories as $category) {
            CategoryProblem::create($category);
        }
    }
}



