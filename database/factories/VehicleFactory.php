<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vehicle>
 */
class VehicleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $cityCode = str_pad($this->faker->numberBetween(1, 81), 2, '0', STR_PAD_LEFT);
        $letters = strtoupper($this->faker->lexify(str_repeat('?', $this->faker->numberBetween(1, 3))));
        $numbers = $this->faker->numberBetween(10, 9999);

        return [
            'plate' => "{$cityCode} {$letters} {$numbers}",
        ];
    }
}
