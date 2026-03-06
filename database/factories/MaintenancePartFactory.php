<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MaintenancePart>
 */
class MaintenancePartFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $parts = ['Yağ Filtresi', 'Hava Filtresi', 'Polen Filtresi', 'Yakıt Filtresi', 'Motor Yağı', 'Fren Balatası', 'Buji', 'Triger Kayışı', 'Akü', 'Silecek Suyu'];

        return [
            // maintenance_id will be provided in seeder
            'name' => $this->faker->randomElement($parts),
            'quantity' => $this->faker->numberBetween(1, 4),
            'unit_price' => $this->faker->randomElement([150, 250, 400, 600, 1200]),
            'note' => $this->faker->boolean(30) ? $this->faker->sentence(3) : null,
        ];
    }
}
