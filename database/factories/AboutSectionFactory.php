<?php

namespace Database\Factories;

use App\Models\AboutSection;
use Illuminate\Database\Eloquent\Factories\Factory;

class AboutSectionFactory extends Factory
{
    protected $model = AboutSection::class;

    public function definition(): array
    {
        return [
            'title' => fake()->sentence(8),
            'subtitle' => fake()->sentence(15),
            'content' => fake()->paragraphs(3, true),
            'image_url' => null,
            'sort_order' => fake()->numberBetween(1, 10),
            'is_active' => true,
        ];
    }
}
