<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            CategorySeeder::class,
            BrandSeeder::class,
            OrderStatusSeeder::class,
            FileSeeder::class,
            ProductSeeder::class,
            PaymentSeeder::class,
            OrderSeeder::class,
        ]);
    }
}
