<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class DoctorProfileFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => 'Dr. Ayesha Rahman',
            'specialty' => 'Consultant Internal Medicine',
            'experience_years' => 14,
            'hero_title' => 'Compassionate care for modern families.',
            'hero_subtitle' => 'Trusted medical support across two clinics.',
            'bio' => fake()->paragraph(4),
            'photo_url' => 'https://images.pexels.com/photos/6129507/pexels-photo-6129507.jpeg?auto=compress&cs=tinysrgb&h=1200&w=800',
            'youtube_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
            'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
            'contact_email' => 'doctor@clinic.com',
            'contact_phone' => '+880 1711 223344',
            'location_text' => 'Dhaka, Bangladesh',
            'cta_text' => 'Book Appointment',
        ];
    }
}
