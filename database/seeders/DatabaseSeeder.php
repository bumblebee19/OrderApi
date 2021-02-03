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
        \App\Models\User::factory(1)->create();
        \App\Models\Product::factory(100)->create();
        \App\Models\Order::factory(5000)->create();
        \App\Models\OrderItem::factory(500)->create();
    }
}
