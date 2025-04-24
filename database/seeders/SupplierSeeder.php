<?php

namespace Database\Seeders;

use App\Models\Supplier;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $suppliers = [
            ['name' => 'PT Sumber Makmur', 'phone' => '081234567890', 'address' => 'Jl. Merdeka No. 1, Jakarta'],
            ['name' => 'CV Berkah Abadi', 'phone' => '082345678901', 'address' => 'Jl. Soekarno-Hatta, Bandung'],
            ['name' => 'Toko Grosir Sejahtera', 'phone' => '083456789012', 'address' => 'Jl. Diponegoro No. 15, Surabaya'],
        ];

        foreach ($suppliers as $supplier) {
            Supplier::create($supplier);
        }
    }
}
