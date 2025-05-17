<?php

namespace Database\Seeders;

use App\Models\CategoryRequestService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoryRequestServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Real-Time Monitoring'],
            ['name' => 'Export to Excel/CSV'],
            ['name' => 'Custom Notification Settings'],
            ['name' => 'Dark Mode Interface'],
            ['name' => 'Role-Based Access Control (RBAC)'],
        ];

        foreach ($categories as $category) {
            CategoryRequestService::create($category);
        }
    }
}



