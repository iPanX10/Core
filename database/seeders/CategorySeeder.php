<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Laptop',
                'slug' => 'laptop',
                'description' => 'Laptop untuk kebutuhan kerja, kuliah, dan gaming.',
            ],
            [
                'name' => 'Monitor',
                'slug' => 'monitor',
                'description' => 'Monitor untuk produktivitas dan gaming.',
            ],
            [
                'name' => 'Aksesoris',
                'slug' => 'aksesoris',
                'description' => 'Aksesoris dan perlengkapan komputer.',
            ],
            [
                'name' => 'Komponen PC',
                'slug' => 'komponen-pc',
                'description' => 'Komponen untuk merakit komputer.',
            ],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(
                ['slug' => $category['slug']],
                $category
            );
        }
    }
}