<?php

namespace Database\Factories;

use App\Models\Appointment;
use App\Models\Clinic;
use Illuminate\Database\Eloquent\Factories\Factory;

class AppointmentFactory extends Factory
{
    protected $model = Appointment::class;

    public function definition(): array
    {
        return [
            'patient_name' => fake()->name(),
            'phone' => fake()->phoneNumber(),
            'email' => fake()->safeEmail(),
            'clinic_id' => Clinic::query()->inRandomOrder()->value('id') ?? Clinic::factory(),
            'appointment_date' => fake()->dateTimeBetween('-5 days', '+20 days')->format('Y-m-d'),
            'appointment_time' => fake()->randomElement(['17:00', '17:30', '18:00', '18:30', '19:00', '19:30']),
            'reason' => fake()->sentence(10),
            'status' => fake()->randomElement(['pending', 'confirmed', 'completed', 'cancelled']),
            'notes' => fake()->optional()->sentence(12),
        ];
    }
}
