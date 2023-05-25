<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categoriesData = [
            ['name' => 'Category 1'],
            ['name' => 'Category 2'],
            ['name' => 'Subcategory 1', 'parent_id' => 1],
            ['name' => 'Subcategory 2', 'parent_id' => 1],
            ['name' => 'Sub-subcategory 1', 'parent_id' => 3],
            ['name' => 'Category 3'],
            ['name' => 'Category 4'],
            ['name' => 'Sub-subcategory 1', 'parent_id' => 5],
        ];

        foreach ($categoriesData as $categoryData) {
            Category::create($categoryData);
        }
    }
}
