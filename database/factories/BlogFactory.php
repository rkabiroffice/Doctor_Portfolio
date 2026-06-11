<?php

namespace Database\Factories;

use App\Models\Blog;
use Illuminate\Database\Eloquent\Factories\Factory;

class BlogFactory extends Factory
{
    protected $model = Blog::class;

    public function definition(): array
    {
        return [
            'title' => fake()->sentence(6),
            'excerpt' => fake()->sentence(18),
            'content' => fake()->paragraphs(4, true),
            'youtube_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
            'image_url' => 'https://images.pexels.com/photos/6129682/pexels-photo-6129682.jpeg?auto=compress&cs=tinysrgb&h=650&w=940',
            'sort_order' => fake()->numberBetween(1, 10),
            'is_published' => true,
        ];
    }
}
