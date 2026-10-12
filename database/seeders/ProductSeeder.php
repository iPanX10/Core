<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $laptop = Category::where('slug', 'laptop')->firstOrFail();
        $monitor = Category::where('slug', 'monitor')->firstOrFail();
        $aksesoris = Category::where('slug', 'aksesoris')->firstOrFail();
        $komponen = Category::where('slug', 'komponen-pc')->firstOrFail();

        $products = [
            [
                'category_id' => $laptop->id,
                'name' => 'ASUS VivoBook 14',
                'slug' => 'asus-vivobook-14',
                'description' => 'Laptop untuk kuliah, pekerjaan, dan produktivitas.',
                'price' => 8500000,
                'image_url' => 'https://placehold.co/600x400?text=ASUS+VivoBook',
                'stock' => 10,
                'discount_percentage' => 10,
                'discount_active' => true,
            ],
            [
                'category_id' => $monitor->id,
                'name' => 'Monitor Xiaomi 27 Inch',
                'slug' => 'monitor-xiaomi-27-inch',
                'description' => 'Monitor 27 inci untuk produktivitas dan hiburan.',
                'price' => 2200000,
                'image_url' => 'https://placehold.co/600x400?text=Monitor+27+Inch',
                'stock' => 15,
                'discount_percentage' => 5,
                'discount_active' => true,
            ],
            [
                'category_id' => $aksesoris->id,
                'name' => 'Mechanical Keyboard',
                'slug' => 'mechanical-keyboard',
                'description' => 'Keyboard mekanis untuk mengetik dan gaming.',
                'price' => 450000,
                'image_url' => 'https://placehold.co/600x400?text=Keyboard',
                'stock' => 20,
                'discount_percentage' => 0,
                'discount_active' => false,
            ],
            [
                'category_id' => $komponen->id,
                'name' => 'RAM DDR4 16GB',
                'slug' => 'ram-ddr4-16gb',
                'description' => 'Memori RAM DDR4 16GB untuk komputer yang kompatibel.',
                'price' => 550000,
                'image_url' => 'https://placehold.co/600x400?text=RAM+16GB',
                'stock' => 12,
                'discount_percentage' => 8,
                'discount_active' => true,
            ],
        ];

        foreach ($products as $product) {
            Product::updateOrCreate(
                ['slug' => $product['slug']],
                $product
            );
        }
    }
}