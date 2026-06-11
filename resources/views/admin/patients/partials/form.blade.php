<div class="grid gap-6 lg:grid-cols-2">
    <div>
        <label class="block text-sm font-medium text-slate-700">Name <span class="text-red-500">*</span></label>
        <input name="name" value="{{ old('name', $patient->name ?? '') }}" type="text" class="mt-2 w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 focus:border-orange-500 focus:outline-none focus:ring-2 focus:ring-orange-500/20" required>
        @error('name')<p class="mt-2 text-xs text-red-600">{{ $message }}</p>@enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-slate-700">Email</label>
        <input name="email" value="{{ old('email', $patient->email ?? '') }}" type="email" class="mt-2 w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 focus:border-orange-500 focus:outline-none focus:ring-2 focus:ring-orange-500/20">
        @error('email')<p class="mt-2 text-xs text-red-600">{{ $message }}</p>@enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-slate-700">Phone</label>
        <input name="phone" value="{{ old('phone', $patient->phone ?? '') }}" type="text" class="mt-2 w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 focus:border-orange-500 focus:outline-none focus:ring-2 focus:ring-orange-500/20">
        @error('phone')<p class="mt-2 text-xs text-red-600">{{ $message }}</p>@enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-slate-700">Sex</label>
        <select name="sex" class="mt-2 w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 focus:border-orange-500 focus:outline-none focus:ring-2 focus:ring-orange-500/20">
            <option value="">Select sex</option>
            @foreach(['male' => 'Male', 'female' => 'Female', 'other' => 'Other'] as $key => $label)
                <option value="{{ $key }}" @selected(old('sex', $patient->sex ?? '') === $key)>{{ $label }}</option>
            @endforeach
        </select>
        @error('sex')<p class="mt-2 text-xs text-red-600">{{ $message }}</p>@enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-slate-700">Age</label>
        <input name="patient_age" value="{{ old('patient_age', $patient->patient_age ?? '') }}" type="text" class="mt-2 w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 focus:border-orange-500 focus:outline-none focus:ring-2 focus:ring-orange-500/20">
        @error('patient_age')<p class="mt-2 text-xs text-red-600">{{ $message }}</p>@enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-slate-700">Status</label>
        <select name="status" class="mt-2 w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 focus:border-orange-500 focus:outline-none focus:ring-2 focus:ring-orange-500/20">
            <option value="pending" @selected(old('status', $patient->status ?? 'pending') === 'pending')>Pending</option>
            <option value="active" @selected(old('status', $patient->status ?? 'pending') === 'active')>Active</option>
        </select>
        @error('status')<p class="mt-2 text-xs text-red-600">{{ $message }}</p>@enderror
    </div>

    <div class="lg:col-span-2">
        <label class="block text-sm font-medium text-slate-700">Address</label>
        <textarea name="address" rows="3" class="mt-2 w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 focus:border-orange-500 focus:outline-none focus:ring-2 focus:ring-orange-500/20">{{ old('address', $patient->address ?? '') }}</textarea>
        @error('address')<p class="mt-2 text-xs text-red-600">{{ $message }}</p>@enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-slate-700">Clinic</label>
        <select name="clinic_id" class="mt-2 w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 focus:border-orange-500 focus:outline-none focus:ring-2 focus:ring-orange-500/20">
            <option value="">Select clinic</option>
            @foreach($clinics as $clinic)
                <option value="{{ $clinic->id }}" @selected(old('clinic_id', $patient->clinic_id ?? '') == $clinic->id)>{{ $clinic->name }}</option>
            @endforeach
        </select>
        @error('clinic_id')<p class="mt-2 text-xs text-red-600">{{ $message }}</p>@enderror
    </div>

    @if(isset($patient))
        <div>
            <label class="block text-sm font-medium text-slate-700">Schedule</label>
            <select name="schedule_id" class="mt-2 w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 focus:border-orange-500 focus:outline-none focus:ring-2 focus:ring-orange-500/20">
                <option value="">Select schedule</option>
                @foreach($schedules as $schedule)
                    <option value="{{ $schedule->id }}" @selected(old('schedule_id', $patient->schedule_id ?? '') == $schedule->id)>{{ $schedule->clinic->name ?? 'Clinic' }} - {{ $schedule->day_name }} {{ $schedule->start_time }}-{{ $schedule->end_time }}</option>
                @endforeach
            </select>
            @error('schedule_id')<p class="mt-2 text-xs text-red-600">{{ $message }}</p>@enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-700">Appointment</label>
            <select name="appointment_id" class="mt-2 w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 focus:border-orange-500 focus:outline-none focus:ring-2 focus:ring-orange-500/20">
                <option value="">Select appointment</option>
                @foreach($appointments as $appointment)
                    <option value="{{ $appointment->id }}" @selected(old('appointment_id', $patient->appointment_id ?? '') == $appointment->id)>{{ $appointment->patient_name }} — {{ $appointment->appointment_date?->format('Y-m-d') }}</option>
                @endforeach
            </select>
            @error('appointment_id')<p class="mt-2 text-xs text-red-600">{{ $message }}</p>@enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-700">Prescription</label>
            <select name="prescription_id" class="mt-2 w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 focus:border-orange-500 focus:outline-none focus:ring-2 focus:ring-orange-500/20">
                <option value="">Select prescription</option>
                @foreach($prescriptions as $prescription)
                    <option value="{{ $prescription->id }}" @selected(old('prescription_id', $patient->prescription_id ?? '') == $prescription->id)>Prescription #{{ $prescription->id }}</option>
                @endforeach
            </select>
            @error('prescription_id')<p class="mt-2 text-xs text-red-600">{{ $message }}</p>@enderror
        </div>
    @endif

    <div class="lg:col-span-2">
        <label class="block text-sm font-medium text-slate-700">Notes</label>
        <textarea name="notes" rows="4" class="mt-2 w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 focus:border-orange-500 focus:outline-none focus:ring-2 focus:ring-orange-500/20">{{ old('notes', $patient->notes ?? '') }}</textarea>
        @error('notes')<p class="mt-2 text-xs text-red-600">{{ $message }}</p>@enderror
    </div>
</div>
