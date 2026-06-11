<?php

namespace Database\Factories;

use App\Models\Appointment;
use App\Models\Prescription;
use Illuminate\Database\Eloquent\Factories\Factory;

class PrescriptionFactory extends Factory
{
    protected $model = Prescription::class;

    public function definition(): array
    {
        return [
            'appointment_id' => Appointment::query()->inRandomOrder()->value('id') ?? Appointment::factory(),
            'diagnosis' => fake()->sentence(8),
            'advice' => fake()->sentence(14),
            'follow_up_date' => fake()->dateTimeBetween('+7 days', '+30 days')->format('Y-m-d'),
        ];
    }
}
