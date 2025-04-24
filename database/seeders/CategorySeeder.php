<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
{
    $categories = [
        ['name' => 'Elektronik'],
        ['name' => 'Pakaian'],
        ['name' => 'Makanan'],
        ['name' => 'Minuman'],
        ['name' => 'Alat Tulis']
    ];

    foreach ($categories as $category) {
        Category::create(
            [
                'name' => Str::title($category['name'])
            ]
        );
    }
}

}
