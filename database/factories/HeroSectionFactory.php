<?php

namespace Database\Factories;

use App\Models\HeroSection;
use Illuminate\Database\Eloquent\Factories\Factory;

class HeroSectionFactory extends Factory
{
    protected $model = HeroSection::class;

    public function definition(): array
    {
        return [
            'title' => fake()->sentence(10),
            'subtitle' => fake()->sentence(20),
            'button_text' => fake()->words(2, true),
            'button_link' => '#book',
            'image_url' => 'https://images.pexels.com/photos/6129507/pexels-photo-6129507.jpeg?auto=compress&cs=tinysrgb&h=1200&w=800',
            'sort_order' => fake()->numberBetween(1, 10),
            'is_active' => true,
        ];
    }
}
