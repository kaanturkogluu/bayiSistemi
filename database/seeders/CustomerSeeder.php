<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Customer::factory(20)->create()->each(function ($customer) {
            // Assign 1 to 3 random vehicles to each customer
            \App\Models\Vehicle::factory(rand(1, 3))->create([
                'customer_id' => $customer->id
            ]);
        });
    }
}
