<div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-8 max-w-2xl">
    <form action="{{ $action }}" method="POST">
        @csrf
        @if($method !== 'POST') @method($method) @endif
        <div class="mb-5">
            <label class="block text-sm font-medium text-slate-700 mb-1.5">Clinic</label>
            <select name="clinic_id" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-all duration-150">
                @foreach($clinics as $clinic)
                    <option value="{{ $clinic->id }}" @selected(old('clinic_id', $schedule?->clinic_id) == $clinic->id)>{{ $clinic->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="grid md:grid-cols-2 gap-5">
            <div class="mb-5">
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Day Name</label>
                <input type="text" name="day_name" value="{{ old('day_name', $schedule?->day_name) }}" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-all duration-150">
            </div>
            <div class="mb-5">
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Day Order</label>
                <input type="number" name="day_order" value="{{ old('day_order', $schedule?->day_order ?? 1) }}" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-all duration-150">
            </div>
            <div class="mb-5">
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Start Time</label>
                <input type="time" name="start_time" value="{{ old('start_time', $schedule?->start_time) }}" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-all duration-150">
            </div>
            <div class="mb-5">
                <label class="block text-sm font-medium text-slate-700 mb-1.5">End Time</label>
                <input type="time" name="end_time" value="{{ old('end_time', $schedule?->end_time) }}" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-all duration-150">
            </div>
            <div class="mb-5">
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Appointment Limit</label>
                <input type="number" name="appointment_limit" value="{{ old('appointment_limit', $schedule?->appointment_limit ?? 20) }}" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-all duration-150">
            </div>
        </div>
        <div class="mb-5 flex items-center gap-3">
            <input type="checkbox" name="is_closed" value="1" {{ old('is_closed', $schedule?->is_closed ?? false) ? 'checked' : '' }} class="rounded border-slate-300 text-orange-600 focus:ring-orange-500">
            <label class="text-sm font-medium text-slate-700">Mark as closed</label>
        </div>
        <button class="bg-orange-600 hover:bg-orange-700 text-white font-medium px-4 py-2 rounded-lg shadow-sm transition-all duration-150">Save Schedule</button>
    </form>
</div>
