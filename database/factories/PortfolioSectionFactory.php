<?php

namespace Database\Factories;

use App\Models\PortfolioSection;
use Illuminate\Database\Eloquent\Factories\Factory;

class PortfolioSectionFactory extends Factory
{
    protected $model = PortfolioSection::class;

    public function definition(): array
    {
        return [
            'section_key' => fake()->unique()->slug(2),
            'label' => fake()->word(),
            'title' => fake()->sentence(5),
            'subtitle' => fake()->sentence(12),
            'content' => fake()->paragraph(3),
            'button_text' => fake()->optional()->words(2, true),
            'button_link' => fake()->optional()->url(),
            'sort_order' => fake()->numberBetween(1, 20),
            'is_active' => true,
        ];
    }
}
