<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Fiction',
            'Non-Fiction',
            'Science',
            'History',
            'Biography'
        ];

        foreach ($categories as $category) {
            \App\Models\BookCategory::create([
                'name' => $category
            ]);
        }
    }
}
