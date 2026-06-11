<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Translation;
use Illuminate\Http\Request;

class TranslationController extends Controller
{
    public function index()
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $translations = Translation::orderByDesc('id')->paginate(20);

        return view('admin.translations.index', compact('translations'));
    }

    public function create()
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        return view('admin.translations.create');
    }

    public function store(Request $request)
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $validated = $request->validate([
            'source_text' => ['required', 'string', 'max:1000'],
            'translated_text' => ['required', 'string', 'max:1000'],
            'language' => ['required', 'string', 'max:10'],
            'context' => ['nullable', 'string', 'max:255'],
            'is_active' => ['nullable', 'in:0,1'],
        ]);

        Translation::create([
            'source_text' => $validated['source_text'],
            'translated_text' => $validated['translated_text'],
            'language' => $validated['language'],
            'context' => $validated['context'] ?? null,
            'is_active' => $request->has('is_active') ? 1 : 0,
        ]);

        return redirect()->route('admin.translations.index')->with('success', 'Translation added successfully.');
    }

    public function edit(Translation $translation)
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        return view('admin.translations.edit', compact('translation'));
    }

    public function update(Request $request, Translation $translation)
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $validated = $request->validate([
            'source_text' => ['required', 'string', 'max:1000'],
            'translated_text' => ['required', 'string', 'max:1000'],
            'language' => ['required', 'string', 'max:10'],
            'context' => ['nullable', 'string', 'max:255'],
            'is_active' => ['nullable', 'in:0,1'],
        ]);

        $translation->update([
            'source_text' => $validated['source_text'],
            'translated_text' => $validated['translated_text'],
            'language' => $validated['language'],
            'context' => $validated['context'] ?? null,
            'is_active' => $request->has('is_active') ? 1 : 0,
        ]);

        return redirect()->route('admin.translations.index')->with('success', 'Translation updated successfully.');
    }

    public function destroy(Translation $translation)
    {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $translation->delete();

        return redirect()->route('admin.translations.index')->with('success', 'Translation deleted successfully.');
    }
}
