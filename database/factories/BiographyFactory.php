<?php

namespace Database\Factories;

use App\Models\Biography;
use Illuminate\Database\Eloquent\Factories\Factory;

class BiographyFactory extends Factory
{
    protected $model = Biography::class;

    public function definition(): array
    {
        return [
            'title' => fake()->name(),
            'subtitle' => fake()->jobTitle(),
            'content' => fake()->paragraphs(4, true),
            'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
            'youtube_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
            'sort_order' => fake()->numberBetween(1, 10),
            'is_active' => true,
        ];
    }
}
