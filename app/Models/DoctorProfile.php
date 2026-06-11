<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoctorProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'specialty',
        'experience_years',
        'hero_title',
        'hero_subtitle',
        'bio',
        'photo_url',
        'youtube_url',
        'video_url',
        'contact_email',
        'contact_phone',
        'location_text',
        'cta_text',
        'logo_text',
        'logo_subtitle',
    ];

    protected $casts = [
        'experience_years' => 'integer',
    ];
}
