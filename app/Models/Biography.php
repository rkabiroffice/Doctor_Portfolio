<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Biography extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'subtitle',
        'content',
        'video_url',
        'youtube_url',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'sort_order' => 'integer',
        'is_active' => 'boolean',
    ];

    public function getYoutubeEmbedUrlAttribute()
    {
        return $this->formatYoutubeEmbedUrl($this->youtube_url);
    }

    public function getVideoEmbedUrlAttribute()
    {
        return $this->isYoutubeLink($this->video_url)
            ? $this->formatYoutubeEmbedUrl($this->video_url)
            : $this->video_url;
    }

    public function isYoutubeLink(?string $url): bool
    {
        return $url && preg_match('/(youtube\.com|youtu\.be)/i', $url);
    }

    protected function formatYoutubeEmbedUrl(?string $url): ?string
    {
        if (! $url) {
            return null;
        }

        if (preg_match('/youtu\.be\/([A-Za-z0-9_-]+)/i', $url, $matches)) {
            return 'https://www.youtube.com/embed/' . $matches[1];
        }

        if (preg_match('/(?:v=|embed\/|shorts\/)([A-Za-z0-9_-]+)/i', $url, $matches)) {
            return 'https://www.youtube.com/embed/' . $matches[1];
        }

        return $url;
    }
}
