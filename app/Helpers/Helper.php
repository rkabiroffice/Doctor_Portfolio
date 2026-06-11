<?php

namespace App\Helpers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Helper
{
    public static function storeUploadedImage(Request $request, string $field, string $directory = 'uploads', ?string $existing = null): ?string
    {
        if (! $request->hasFile($field) || ! $request->file($field)->isValid()) {
            return $existing;
        }

        $file = $request->file($field);
        $filename = time() . '_' . Str::random(32) . '.' . $file->extension();

        $path = $file->storeAs($directory, $filename, 'public');

        return Storage::url($path);
    }

    public static function storeUploadedFile(Request $request, string $field, string $directory = 'uploads', ?string $existing = null): ?string
    {
        if (! $request->hasFile($field) || ! $request->file($field)->isValid()) {
            return $existing;
        }

        $file = $request->file($field);
        $filename = time() . '_' . Str::random(32) . '.' . $file->extension();
        $path = $file->storeAs($directory, $filename, 'public');

        return Storage::url($path);
    }

    public static function normalizeYoutubeUrl(?string $url): ?string
    {
        if (! $url) {
            return null;
        }

        $url = trim($url);

        if (! Str::contains($url, ['youtube.com', 'youtu.be'])) {
            return $url;
        }

        if (Str::contains($url, 'youtu.be/')) {
            $videoId = Str::afterLast(Str::before($url, '?'), '/');
        } elseif (Str::contains($url, 'youtube.com/shorts/')) {
            $videoId = Str::afterLast(Str::before($url, '?'), '/');
        } else {
            parse_str(parse_url($url, PHP_URL_QUERY) ?: '', $query);
            $videoId = $query['v'] ?? null;

            if (! $videoId && preg_match('/\/embed\/([A-Za-z0-9_-]+)/i', $url, $matches)) {
                $videoId = $matches[1];
            }
        }

        return $videoId ? 'https://www.youtube.com/embed/' . $videoId : $url;
    }

    public static function normalizeGoogleMapsEmbedUrl(?string $url): ?string
    {
        if (! $url) {
            return null;
        }

        $url = trim($url);

        if (Str::contains($url, '/maps/embed')) {
            return $url;
        }

        if (Str::contains($url, ['maps.google.com', 'google.com/maps'])) {
            $parsedUrl = parse_url($url);
            $query = $parsedUrl['query'] ?? '';
            parse_str($query, $queryParams);

            if (! empty($queryParams['q'])) {
                return 'https://maps.google.com/maps?q=' . urlencode($queryParams['q']) . '&output=embed';
            }

            if (preg_match('/maps\.google\.com\/\?q=([^&]+)/i', $url, $matches) || preg_match('/google\.com\/maps\?q=([^&]+)/i', $url, $matches)) {
                return 'https://maps.google.com/maps?q=' . urlencode(urldecode($matches[1])) . '&output=embed';
            }

            if (preg_match('/google\.com\/maps\/place\//i', $url) || preg_match('/google\.com\/maps\//i', $url)) {
                return preg_replace('#(https?://)(www\.)?google\.com/maps#i', '$1$2google.com/maps/embed', $url);
            }
        }

        return $url;
    }
}
