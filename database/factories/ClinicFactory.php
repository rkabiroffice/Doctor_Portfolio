<?php

namespace Database\Factories;

use App\Models\Clinic;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClinicFactory extends Factory
{
    protected $model = Clinic::class;

    public function definition(): array
    {
        static $index = 0;

        $clinics = [
            [
                'name' => 'CityCare Chamber',
                'address' => 'House 12, Road 7, Dhanmondi',
                'city' => 'Dhaka',
                'phones' => ['+880 1911 000111'],
            ],
            [
                'name' => 'NorthView Medical Center',
                'address' => 'Plot 8, Sector 11, Uttara',
                'city' => 'Dhaka',
                'phones' => ['+880 1922 333444'],
            ],
        ];

        $clinic = $clinics[$index % count($clinics)];
        $index++;

        return [
            'name' => $clinic['name'],
            'address' => $clinic['address'],
            'city' => $clinic['city'],
            'phones' => $clinic['phones'],
            'map_embed_url' => 'https://maps.google.com',
            'is_active' => true,
        ];
    }
}
