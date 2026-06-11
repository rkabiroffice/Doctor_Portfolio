<?php

namespace Database\Factories;

use App\Models\Education;
use Illuminate\Database\Eloquent\Factories\Factory;

class EducationFactory extends Factory
{
    protected $model = Education::class;

    public function definition(): array
    {
        $items = [
            ['degree' => 'MBBS', 'institution' => 'Dhaka Medical College', 'type' => 'Education'],
            ['degree' => 'MD in Internal Medicine', 'institution' => 'Bangabandhu Sheikh Mujib Medical University', 'type' => 'Education'],
            ['degree' => 'Board Certification in Diabetes Care', 'institution' => 'Bangladesh College of Physicians', 'type' => 'Certification'],
            ['degree' => 'Advanced Clinical Endocrinology Training', 'institution' => 'Apollo MedSkills Institute', 'type' => 'Certification'],
            ['degree' => 'Continuing Medical Education in Preventive Care', 'institution' => 'WHO Regional Program', 'type' => 'Training'],
            ['degree' => 'Clinical Nutrition & Metabolic Health Workshop', 'institution' => 'South Asia Medical Forum', 'type' => 'Training'],
        ];

        static $index = 0;
        $item = $items[$index % count($items)];
        $index++;

        return [
            'degree' => $item['degree'],
            'institution' => $item['institution'],
            'year_completed' => fake()->numberBetween(2008, 2024),
            'details' => fake()->sentence(12),
            'type' => $item['type'],
        ];
    }
}
