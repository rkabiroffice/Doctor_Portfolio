<?php

namespace App\Models;

use App\Helpers\Helper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clinic extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'city',
        'phones',
        'map_embed_url',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'phones' => 'json',
    ];

    public function getMapIframeUrlAttribute(): ?string
    {
        return Helper::normalizeGoogleMapsEmbedUrl($this->map_embed_url);
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}
