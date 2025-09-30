<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $appleCategory = Category::where('slug', 'apple')->first();
        $samsungCategory = Category::where('slug', 'samsung')->first();
        $vivoCategory = Category::where('slug', 'vivo')->first();

        // Apple products
        Product::create([
            'name' => 'iPhone 16 Pro',
            'slug' => Str::slug('iPhone 16 Pro'),
            'price' => 1200,
            'category_id' => $appleCategory->id
        ]);

        Product::create([
            'name' => 'iPhone 15',
            'slug' => Str::slug('iPhone 15'),
            'price' => 999,
            'category_id' => $appleCategory->id
        ]);

        // Samsung products
        Product::create([
            'name' => 'Samsung Galaxy S24',
            'slug' => Str::slug('Samsung Galaxy S24'),
            'price' => 1100,
            'category_id' => $samsungCategory->id
        ]);

        // Vivo products
        Product::create([
            'name' => 'Vivo X100',
            'slug' => Str::slug('Vivo X100'),
            'price' => 700,
            'category_id' => $vivoCategory->id
        ]);
    }
}
