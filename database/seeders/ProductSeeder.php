<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\Unit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = Category::all();
        $units = Unit::all();

        Product::create([
            'name' => 'Kemeja Lengan Panjang',
            'category_id' => $categories->where('name', 'Pakaian')->first()?->id ?? 1,
            'unit_id' => $units->where('name', 'Buah')->first()?->id ?? 1,
            'price' => 120000,
            'cost' => 100000,
            'stock' => fake()->numberBetween(10, 50)
        ]);

        Product::create([
            'name' => 'Air Mineral 1.5L',
            'category_id' => $categories->where('name', 'Minuman')->first()?->id ?? 1,
            'unit_id' => $units->where('name', 'Botol')->first()?->id ?? 1,
            'price' => 6000,
            'cost' => 4000,
            'stock' => fake()->numberBetween(10, 50)
        ]);

        Product::create([
            'name' => 'Pulpen Biru',
            'category_id' => $categories->where('name', 'Alat Tulis')->first()?->id ?? 1,
            'unit_id' => $units->where('name', 'Buah')->first()?->id ?? 1,
            'price' => 2500,
            'cost' => 2000,
            'stock' => fake()->numberBetween(10, 50)
        ]);
    }
}
