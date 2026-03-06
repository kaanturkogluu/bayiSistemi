<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MaintenanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Generate 5 random maintenances
        for ($i = 0; $i < 5; $i++) {
            // Pick a random customer that has at least one vehicle
            $customer = \App\Models\Customer::has('vehicles')->inRandomOrder()->first();

            if (!$customer) {
                continue; // Skip if no eligible customers
            }

            $vehicle = $customer->vehicles()->inRandomOrder()->first();

            $maintenance = \App\Models\Maintenance::factory()->create([
                'customer_id' => $customer->id,
                'vehicle_id' => $vehicle->id,
            ]);

            // Add 1 to 4 random parts
            $parts = \App\Models\MaintenancePart::factory(rand(1, 4))->create([
                'maintenance_id' => $maintenance->id
            ]);

            // Calculate total cost
            $partsTotal = $parts->sum(function ($part) {
                return $part->quantity * $part->unit_price;
            });

            $maintenance->update([
                'total_cost' => $maintenance->labor_cost + $partsTotal
            ]);
        }
    }
}
