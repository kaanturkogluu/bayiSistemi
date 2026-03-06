<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Maintenance>
 */
class MaintenanceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // customer_id and vehicle_id will be provided in the seeder
            'labor_cost' => $this->faker->randomElement([500, 750, 1000, 1500, 2000]),
            'total_cost' => 0, // Will update after parts
            'created_at' => $this->faker->dateTimeBetween('-6 months', 'now'),
        ];
    }
}
