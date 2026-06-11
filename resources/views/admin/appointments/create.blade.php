@extends('layouts.admin')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-8 max-w-5xl mx-auto">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-2xl font-semibold text-slate-900">Create Appointment</h2>
            <p class="text-sm text-slate-500 mt-1">Create a new confirmed appointment and attach it to an existing patient when selected.</p>
        </div>
        <a href="{{ route('admin.appointments.index') }}" class="inline-flex items-center gap-2 bg-slate-100 hover:bg-slate-200 text-slate-700 px-4 py-2 rounded-lg text-sm font-medium transition">Back to Appointments</a>
    </div>

    <form action="{{ route('admin.appointments.store') }}" method="POST">
        @csrf
        @if($patient)
            <input type="hidden" name="patient_id" value="{{ $patient->id }}">
        @endif

        <div class="grid md:grid-cols-2 gap-6">
            @if(!$patient)
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Patient Name <span class="text-red-500">*</span></label>
                        <input type="text" name="patient_name" value="{{ old('patient_name') }}" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500">
                        @error('patient_name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Phone <span class="text-red-500">*</span></label>
                        <input type="text" name="phone" value="{{ old('phone') }}" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500">
                        @error('phone')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500">
                        @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Age <span class="text-red-500">*</span></label>
                            <input type="number" name="patient_age" value="{{ old('patient_age') }}" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500">
                            @error('patient_age')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Sex <span class="text-red-500">*</span></label>
                            <select name="sex" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500">
                                <option value="">Select sex</option>
                                <option value="male" {{ old('sex') == 'male' ? 'selected' : '' }}>Male</option>
                                <option value="female" {{ old('sex') == 'female' ? 'selected' : '' }}>Female</option>
                                <option value="other" {{ old('sex') == 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('sex')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </div>
            @else
                <div class="bg-slate-50 rounded-2xl border border-slate-200 p-5">
                    <p class="text-sm text-slate-500 mb-2">Creating re-appointment for existing patient</p>
                    <div class="text-slate-900 font-semibold text-lg">{{ $patient->name }}</div>
                    <div class="text-sm text-slate-600">Patient ID: <span class="font-semibold">{{ $patient->id }}</span></div>
                    <div class="text-sm text-slate-600">Phone: {{ $patient->phone }}</div>
                    <div class="text-sm text-slate-600">Email: {{ $patient->email ?? 'N/A' }}</div>
                    <div class="text-sm text-slate-600">Age: {{ $patient->patient_age }}</div>
                    <div class="text-sm text-slate-600">Sex: {{ ucfirst($patient->sex) }}</div>
                </div>
            @endif

            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Clinic <span class="text-red-500">*</span></label>
                    <select name="clinic_id" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500">
                        <option value="">Select clinic</option>
                        @foreach($clinics as $clinic)
                            <option value="{{ $clinic->id }}" {{ old('clinic_id') == $clinic->id ? 'selected' : '' }}>{{ $clinic->name }}</option>
                        @endforeach
                    </select>
                    @error('clinic_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Appointment Date <span class="text-red-500">*</span></label>
                    <input type="date" name="appointment_date" value="{{ old('appointment_date') }}" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500">
                    @error('appointment_date')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Appointment Time <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        </span>
                        <input type="time" name="appointment_time" value="{{ old('appointment_time') }}" class="w-full rounded-lg border border-slate-200 bg-white pl-11 pr-3 py-2.5 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500">
                    </div>
                    @error('appointment_time')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Reason</label>
                    <textarea name="reason" rows="4" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500">{{ old('reason') }}</textarea>
                    @error('reason')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Notes</label>
                    <textarea name="notes" rows="4" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500">{{ old('notes') }}</textarea>
                </div>
            </div>
        </div>

        <div class="mt-8 flex items-center gap-3">
            <button type="submit" class="bg-orange-600 hover:bg-orange-700 text-white font-medium px-6 py-3 rounded-lg transition-all duration-150">Save Appointment</button>
            <a href="{{ route('admin.appointments.index') }}" class="text-slate-600 hover:text-slate-900">Cancel</a>
        </div>
    </form>
</div>
@endsection
