<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewApiController extends Controller
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

        return response()->json(Review::latest()->get());
    }

    public function store(Request $request)
    {
        if ($guard = $this->guard()) {
            return $guard;
        }

        $validated = $request->validate([
            'patient_name' => ['required', 'string', 'max:255'],
            'designation' => ['nullable', 'string', 'max:255'],
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'review_text' => ['required', 'string'],
            'is_published' => ['nullable', 'boolean'],
        ]);

        $validated['is_published'] = $request->boolean('is_published');

        return response()->json(Review::create($validated), 201);
    }

    public function show(Review $review)
    {
        if ($guard = $this->guard()) {
            return $guard;
        }

        return response()->json($review);
    }

    public function update(Request $request, Review $review)
    {
        if ($guard = $this->guard()) {
            return $guard;
        }

        $validated = $request->validate([
            'patient_name' => ['required', 'string', 'max:255'],
            'designation' => ['nullable', 'string', 'max:255'],
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'review_text' => ['required', 'string'],
            'is_published' => ['nullable', 'boolean'],
        ]);

        $validated['is_published'] = $request->boolean('is_published');
        $review->update($validated);

        return response()->json($review);
    }

    public function destroy(Review $review)
    {
        if ($guard = $this->guard()) {
            return $guard;
        }

        $review->delete();

        return response()->json(['message' => 'Review deleted successfully.']);
    }
}
