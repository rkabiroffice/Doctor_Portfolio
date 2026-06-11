<?php

namespace Database\Factories;

use App\Models\Review;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReviewFactory extends Factory
{
    protected $model = Review::class;

    public function definition(): array
    {
        return [
            'patient_name' => fake()->name(),
            'designation' => fake()->randomElement(['Patient', 'Working Professional', 'Parent', 'Teacher', 'Entrepreneur']),
            'rating' => fake()->numberBetween(4, 5),
            'review_text' => fake()->paragraph(2),
            'is_published' => true,
        ];
    }
}
