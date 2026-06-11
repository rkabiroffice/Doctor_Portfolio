<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PortfolioSection;
use Illuminate\Http\Request;

class PortfolioSectionApiController extends Controller
{
    protected function guard()
    {
        if (! session('admin_logged_in')) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        return null;
    }

    public function index()
    {
        if ($guard = $this->guard()) {
            return $guard;
        }

        return response()->json(PortfolioSection::orderBy('sort_order')->get());
    }

    public function store(Request $request)
    {
        if ($guard = $this->guard()) {
            return $guard;
        }

        $validated = $request->validate([
            'section_key' => ['required', 'string', 'max:100', 'unique:portfolio_sections,section_key'],
            'label' => ['required', 'string', 'max:100'],
            'title' => ['required', 'string', 'max:255'],
            'subtitle' => ['nullable', 'string', 'max:500'],
            'content' => ['nullable', 'string'],
            'button_text' => ['nullable', 'string', 'max:100'],
            'button_link' => ['nullable', 'string', 'max:255'],
            'sort_order' => ['required', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        return response()->json(PortfolioSection::create($validated), 201);
    }

    public function show(PortfolioSection $section)
    {
        if ($guard = $this->guard()) {
            return $guard;
        }

        return response()->json($section);
    }

    public function update(Request $request, PortfolioSection $section)
    {
        if ($guard = $this->guard()) {
            return $guard;
        }

        $validated = $request->validate([
            'section_key' => ['required', 'string', 'max:100', 'unique:portfolio_sections,section_key,'.$section->id],
            'label' => ['required', 'string', 'max:100'],
            'title' => ['required', 'string', 'max:255'],
            'subtitle' => ['nullable', 'string', 'max:500'],
            'content' => ['nullable', 'string'],
            'button_text' => ['nullable', 'string', 'max:100'],
            'button_link' => ['nullable', 'string', 'max:255'],
            'sort_order' => ['required', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $validated['is_active'] = $request->boolean('is_active');
        $section->update($validated);

        return response()->json($section);
    }

    public function destroy(PortfolioSection $section)
    {
        if ($guard = $this->guard()) {
            return $guard;
        }

        $section->delete();

        return response()->json(['message' => 'Section deleted successfully.']);
    }
}
