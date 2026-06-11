<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;

class BlogApiController extends Controller
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

        return response()->json(Blog::orderBy('sort_order')->latest()->get());
    }

    public function store(Request $request)
    {
        if ($guard = $this->guard()) {
            return $guard;
        }

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'excerpt' => ['required', 'string', 'max:500'],
            'content' => ['required', 'string'],
            'youtube_url' => ['nullable', 'url'],
            'image_url' => ['required', 'url'],
            'sort_order' => ['required', 'integer', 'min:0'],
            'is_published' => ['nullable', 'boolean'],
        ]);

        $validated['is_published'] = $request->boolean('is_published');

        return response()->json(Blog::create($validated), 201);
    }

    public function show(Blog $blog)
    {
        if ($guard = $this->guard()) {
            return $guard;
        }

        return response()->json($blog);
    }

    public function update(Request $request, Blog $blog)
    {
        if ($guard = $this->guard()) {
            return $guard;
        }

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'excerpt' => ['required', 'string', 'max:500'],
            'content' => ['required', 'string'],
            'youtube_url' => ['nullable', 'url'],
            'image_url' => ['required', 'url'],
            'sort_order' => ['required', 'integer', 'min:0'],
            'is_published' => ['nullable', 'boolean'],
        ]);

        $validated['is_published'] = $request->boolean('is_published');
        $blog->update($validated);

        return response()->json($blog);
    }

    public function destroy(Blog $blog)
    {
        if ($guard = $this->guard()) {
            return $guard;
        }

        $blog->delete();

        return response()->json(['message' => 'Blog deleted successfully.']);
    }
}
