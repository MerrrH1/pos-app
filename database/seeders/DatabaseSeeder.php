<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => Str::title('mervin howard'),
            'email' => 'mervinhoward@gmail.com',
            'role' => 'super_admin'
        ]);
        User::factory()->create([
            'name' => Str::title('budi'),
            'email' => 'budi@gmail.com',
            'role' => 'sales_admin'
        ]);
        User::factory()->create([
            'name' => Str::title('andi'),
            'email' => 'andi@gmail.com',
            'role' => 'purchases_admin'
        ]);
        // $user = User::find(1);
        // $user->update([
        //     'role' => 'super_admin'
        // ]);
        $this->call([
            CategorySeeder::class,
            CustomerSeeder::class,
            UnitSeeder::class,
            ProductSeeder::class,
            SupplierSeeder::class
        ]);
    }
}
