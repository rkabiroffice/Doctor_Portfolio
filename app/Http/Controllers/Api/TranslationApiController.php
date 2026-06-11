<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Translation;
use Illuminate\Http\Request;

class TranslationApiController extends Controller
{
    public function lookup(Request $request)
    {
        $validated = $request->validate([
            'texts' => ['nullable', 'array'],
            'texts.*' => ['string'],
            'text' => ['nullable', 'string'],
            'language' => ['nullable', 'string', 'max:10'],
        ]);

        $language = $validated['language'] ?? 'bn';
        $texts = [];

        if (! empty($validated['text'])) {
            $texts = [$validated['text']];
        } elseif (! empty($validated['texts'])) {
            $texts = array_values(array_filter($validated['texts'], fn ($item) => is_string($item) && trim($item) !== ''));
        }

        $translations = Translation::translateMany($texts, $language);

        return response()->json([
            'translations' => $translations,
            'language' => $language,
        ]);
    }
}
