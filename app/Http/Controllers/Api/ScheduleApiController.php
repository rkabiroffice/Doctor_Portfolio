<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use Illuminate\Http\Request;

class ScheduleApiController extends Controller
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

        return response()->json(Schedule::with('clinic')->orderBy('day_order')->get());
    }

    public function store(Request $request)
    {
        if ($guard = $this->guard()) {
            return $guard;
        }

        $validated = $request->validate([
            'clinic_id' => ['required', 'exists:clinics,id'],
            'day_name' => ['required', 'string', 'max:50'],
            'day_order' => ['required', 'integer', 'min:1', 'max:7'],
            'start_time' => ['required'],
            'end_time' => ['required'],
            'appointment_limit' => ['required', 'integer', 'min:1'],
            'is_closed' => ['nullable', 'boolean'],
        ]);

        $validated['is_closed'] = $request->boolean('is_closed');

        return response()->json(Schedule::create($validated), 201);
    }

    public function show(Schedule $schedule)
    {
        if ($guard = $this->guard()) {
            return $guard;
        }

        return response()->json($schedule->load('clinic'));
    }

    public function update(Request $request, Schedule $schedule)
    {
        if ($guard = $this->guard()) {
            return $guard;
        }

        $validated = $request->validate([
            'clinic_id' => ['required', 'exists:clinics,id'],
            'day_name' => ['required', 'string', 'max:50'],
            'day_order' => ['required', 'integer', 'min:1', 'max:7'],
            'start_time' => ['required'],
            'end_time' => ['required'],
            'appointment_limit' => ['required', 'integer', 'min:1'],
            'is_closed' => ['nullable', 'boolean'],
        ]);

        $validated['is_closed'] = $request->boolean('is_closed');
        $schedule->update($validated);

        return response()->json($schedule);
    }

    public function destroy(Schedule $schedule)
    {
        if ($guard = $this->guard()) {
            return $guard;
        }

        $schedule->delete();

        return response()->json(['message' => 'Schedule deleted successfully.']);
    }
}
