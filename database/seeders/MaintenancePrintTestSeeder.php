<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Maintenance;
use Illuminate\Database\Seeder;

class MaintenancePrintTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customer = Customer::first() ?? Customer::factory()->create();
        $vehicle = $customer->vehicles()->first() ?? $customer->vehicles()->create([
            'plate' => '34 TEST 2026',
            'brand' => 'Test Brand',
            'model' => 'Test Model',
            'year' => 2023,
            'color' => 'Beyaz',
        ]);
        
        $maintenance = Maintenance::create([
            'customer_id' => $customer->id,
            'vehicle_id' => $vehicle->id,
            'km' => 150000,
            'labor_cost' => 2500,
            'total_cost' => 0, // Will calculate below
            'status' => 'bekliyor',
        ]);

        $totalCost = $maintenance->labor_cost;
        $parts = [];

        for ($i = 1; $i <= 25; $i++) {
            $price = rand(150, 850);
            $qty = rand(1, 3);
            $parts[] = [
                'name' => "Test Yedek Parça $i",
                'quantity' => $qty,
                'unit_price' => $price,
                'note' => "Otomatik eklendi #$i",
            ];
            $totalCost += ($price * $qty);
        }

        $maintenance->parts()->createMany($parts);
        $maintenance->update(['total_cost' => $totalCost]);

        $maintenance->transactions()->create([
            'customer_id' => $customer->id,
            'type' => 'debt',
            'amount' => $totalCost,
            'description' => 'Bakım Hizmet Bedeli (#' . str_pad($maintenance->id, 5, '0', STR_PAD_LEFT) . ')',
            'date' => now(),
        ]);
        $customer->recalculateBalance();

        $this->command->info("25 parçalık bakım test kaydı başarıyla oluşturuldu! Bakım ID: " . $maintenance->id);
    }
}
