<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Customer::create(
            [
                'name' => 'Andi Wijaya',
                'phone' => '081234567890',
                'address' => 'Jl. Merdeka No. 10, Jakarta',

            ]
        );

        Customer::create(
            [
                'name' => 'Siti Nurhaliza',
                'phone' => '081298765432',
                'address' => 'Jl. Mawar No. 20, Bandung',

            ]
        );

        Customer::create(
            [
                'name' => 'Budi Santoso',
                'phone' => '082112345678',
                'address' => 'Jl. Melati No. 15, Surabaya',

            ]
        );
    }
}
