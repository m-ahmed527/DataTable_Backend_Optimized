<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        // Main Category
        $electronics = Category::create([
            'name' => 'Electronics',
            'slug' => Str::slug('Electronics'),
            'parent_id' => null,
            'status' => 1
        ]);

        // Sub Category
        $smartPhones = Category::create([
            'name' => 'Smart Phones',
            'slug' => Str::slug('Smart Phones'),
            'parent_id' => $electronics->id,
            'status' => 1
        ]);

        // Brands (Leaf Categories)
        $apple = Category::create([
            'name' => 'Apple',
            'slug' => Str::slug('Apple'),
            'parent_id' => $smartPhones->id,
            'status' => 1
        ]);

        $samsung = Category::create([
            'name' => 'Samsung',
            'slug' => Str::slug('Samsung'),
            'parent_id' => $smartPhones->id,
            'status' => 1
        ]);

        $vivo = Category::create([
            'name' => 'Vivo',
            'slug' => Str::slug('Vivo'),
            'parent_id' => $smartPhones->id,
            'status' => 1
        ]);
    }
}
