<?php

namespace Database\Factories;

use App\Models\Medicine;
use App\Models\Prescription;
use App\Models\PrescriptionMedicine;
use Illuminate\Database\Eloquent\Factories\Factory;

class PrescriptionMedicineFactory extends Factory
{
    protected $model = PrescriptionMedicine::class;

    public function definition(): array
    {
        return [
            'prescription_id' => Prescription::factory(),
            'medicine_id' => Medicine::factory(),
            'morning_dose' => fake()->randomElement(['1', '0.5', '2', null]),
            'afternoon_dose' => fake()->randomElement(['1', '0.5', '2', null]),
            'night_dose' => fake()->randomElement(['1', '0.5', '2', null]),
            'duration' => fake()->randomElement(['5 days', '7 days', '10 days', '2 weeks', '1 month']),
            'instruction' => fake()->optional()->randomElement(['After meal', 'Before meal', 'With food', 'At bedtime']),
        ];
    }
}
