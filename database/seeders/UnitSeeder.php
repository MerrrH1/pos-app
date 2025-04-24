<?php

namespace Database\Seeders;

use App\Models\Unit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $units = [
            ['name' => 'buah'],
            ['name' => 'kilogram'],
            ['name' => 'liter'],
            ['name' => 'meter'],
            ['name' => 'pack'],
            ['name' => 'botol']
        ];
        foreach ($units as $unit) {
            Unit::create(
                [
                    'name' => Str::title($unit['name'])
                ]
            );
        }
    }
}
