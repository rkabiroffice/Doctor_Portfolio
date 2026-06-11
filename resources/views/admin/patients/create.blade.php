@extends('layouts.admin')

@section('content')
<div class="flex items-center justify-between mb-6 gap-4 flex-wrap">
    <div>
        <h1 class="text-2xl font-semibold text-slate-900">Add New Patient</h1>
        <p class="text-sm text-slate-500 mt-1">Create a patient record. Schedule, appointment, and prescription fields are added later when needed.</p>
    </div>
    <a href="{{ route('admin.patients.index') }}" class="bg-slate-100 hover:bg-slate-200 text-slate-700 font-medium px-4 py-2 rounded-lg transition-all duration-150">Back to Patients</a>
</div>

<div class="bg-white rounded-2xl shadow-sm overflow-hidden border border-slate-100 p-6">
    <form action="{{ route('admin.patients.store') }}" method="POST">
        @csrf

        @include('admin.patients.partials.form', ['patient' => null, 'clinics' => $clinics, 'schedules' => $schedules, 'appointments' => $appointments, 'prescriptions' => $prescriptions])

        <div class="mt-6 flex items-center gap-3">
            <button type="submit" class="bg-orange-600 hover:bg-orange-700 text-white font-medium px-5 py-3 rounded-lg transition-all duration-150">Save Patient</button>
            <a href="{{ route('admin.patients.index') }}" class="bg-slate-100 hover:bg-slate-200 text-slate-700 font-medium px-5 py-3 rounded-lg transition-all duration-150">Cancel</a>
        </div>
    </form>
</div>
@endsection
