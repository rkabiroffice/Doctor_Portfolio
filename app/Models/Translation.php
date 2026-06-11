<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Translation extends Model
{
    use HasFactory;

    protected $fillable = [
        'source_text',
        'translated_text',
        'language',
        'context',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected static function booted()
    {
        static::saving(function (self $translation) {
            if ($translation->source_text !== null) {
                $translation->source_hash = hash('sha256', trim($translation->source_text));
            }
        });
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public static function translateMany(array $texts, string $language = 'bn'): array
    {
        if (empty($texts)) {
            return [];
        }

        return self::active()
            ->where('language', $language)
            ->whereIn('source_text', $texts)
            ->pluck('translated_text', 'source_text')
            ->toArray();
    }
}
