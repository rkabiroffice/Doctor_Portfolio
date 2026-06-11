<?php

namespace Database\Factories;

use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;

class ServiceFactory extends Factory
{
    protected $model = Service::class;

    public function definition(): array
    {
        $titles = [
            'Diabetes Management',
            'Hypertension Care',
            'General Consultation',
            'Preventive Health Check',
            'Thyroid Evaluation',
            'Lifestyle Counseling',
        ];

        static $order = 0;
        $title = $titles[$order % count($titles)];
        $order++;

        return [
            'title' => $title,
            'description' => fake()->sentence(16),
            'icon' => 'heart',
            'sort_order' => $order,
            'is_active' => true,
        ];
    }
}
