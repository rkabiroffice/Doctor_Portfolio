<?php

namespace Database\Factories;

use App\Models\Medicine;
use Illuminate\Database\Eloquent\Factories\Factory;

class MedicineFactory extends Factory
{
    protected $model = Medicine::class;

    public function definition(): array
    {
        $medicines = [
            ['name' => 'Paracetamol 500mg', 'generic_name' => 'Paracetamol', 'strength' => '500mg', 'dosage_form' => 'Tablet'],
            ['name' => 'Metformin 500mg', 'generic_name' => 'Metformin', 'strength' => '500mg', 'dosage_form' => 'Tablet'],
            ['name' => 'Omeprazole 20mg', 'generic_name' => 'Omeprazole', 'strength' => '20mg', 'dosage_form' => 'Capsule'],
            ['name' => 'Atorvastatin 10mg', 'generic_name' => 'Atorvastatin', 'strength' => '10mg', 'dosage_form' => 'Tablet'],
            ['name' => 'Amlodipine 5mg', 'generic_name' => 'Amlodipine', 'strength' => '5mg', 'dosage_form' => 'Tablet'],
        ];

        static $index = 0;
        $medicine = $medicines[$index % count($medicines)];
        $index++;

        return [
            'name' => $medicine['name'],
            'generic_name' => $medicine['generic_name'],
            'strength' => $medicine['strength'],
            'dosage_form' => $medicine['dosage_form'],
            'manufacturer' => fake()->company(),
            'notes' => fake()->optional()->sentence(10),
        ];
    }
}
