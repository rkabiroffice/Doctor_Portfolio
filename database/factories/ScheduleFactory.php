<?php

namespace Database\Factories;

use App\Models\Schedule;
use Illuminate\Database\Eloquent\Factories\Factory;

class ScheduleFactory extends Factory
{
    protected $model = Schedule::class;

    public function definition(): array
    {
        static $day = 1;
        $days = [
            1 => 'Monday',
            2 => 'Tuesday',
            3 => 'Wednesday',
            4 => 'Thursday',
            5 => 'Friday',
            6 => 'Saturday',
        ];

        $currentDay = $day;
        $day = $day === 6 ? 1 : $day + 1;

        return [
            'day_name' => $days[$currentDay],
            'day_order' => $currentDay,
            'start_time' => '17:00',
            'end_time' => '21:00',
            'appointment_limit' => fake()->numberBetween(12, 24),
            'is_closed' => false,
        ];
    }
}
