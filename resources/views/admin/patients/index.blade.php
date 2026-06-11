@extends('layouts.admin')

@section('content')
<div class="flex items-center justify-between mb-6 gap-4 flex-wrap">
    <form method="GET" class="flex flex-wrap items-center gap-3">
        <input type="text" name="search" value="{{ $search }}" placeholder="Search patients..." class="w-72 rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-all duration-150">
        <select name="clinic_id" class="rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-all duration-150">
            <option value="">All Clinics</option>
            @foreach($clinics as $clinic)
                <option value="{{ $clinic->id }}" @selected($clinicId == $clinic->id)>{{ $clinic->name }}</option>
            @endforeach
        </select>
        <select name="schedule_id" class="rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-all duration-150">
            <option value="">All Schedules</option>
            @foreach($schedules as $schedule)
                <option value="{{ $schedule->id }}" @selected($scheduleId == $schedule->id)>{{ $schedule->clinic->name ?? 'Clinic' }} - {{ $schedule->day_name }} {{ $schedule->start_time }}-{{ $schedule->end_time }}</option>
            @endforeach
        </select>
        <select name="status" class="rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-all duration-150">
            <option value="">All Statuses</option>
            <option value="pending" @selected($status === 'pending')>Pending</option>
            <option value="active" @selected($status === 'active')>Active</option>
        </select>
        <button class="bg-white hover:bg-slate-50 text-slate-700 font-medium px-4 py-2 rounded-lg border border-slate-200 transition-all duration-150">Filter</button>
    </form>
    <div class="flex items-center gap-2 flex-wrap">
        <a href="{{ route('admin.patients.create') }}" class="bg-orange-600 hover:bg-orange-700 text-white font-medium px-4 py-2 rounded-lg shadow-sm transition-all duration-150">Add Patient</a>
    </div>
</div>

<div class="bg-white rounded-2xl shadow-sm overflow-hidden border border-slate-100">
    <table class="min-w-full">
        <thead class="bg-slate-50 border-b border-slate-200">
            <tr>
                <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Patient ID</th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Patient</th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Status</th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Clinic / Schedule</th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Appointment</th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Prescription</th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($patients as $patient)
                <tr class="border-b border-slate-100 hover:bg-slate-50 transition-colors duration-100">
                    <td class="px-4 py-3.5 text-sm text-slate-700 font-medium">#{{ $patient->id }}</td>
                    <td class="px-4 py-3.5 text-sm text-slate-700">
                        <div class="font-medium">{{ $patient->name }}</div>
                        <div class="text-slate-500 text-xs mt-1">{{ $patient->email ?? 'No email' }}</div>
                        <div class="text-slate-500 text-xs mt-1">{{ $patient->phone ?? 'No phone' }}</div>
                    </td>
                    <td class="px-4 py-3.5 text-sm text-slate-700">
                        <span class="inline-flex items-center rounded-full px-2.5 py-1 text-[11px] font-semibold uppercase tracking-[0.16em] {{ $patient->status === 'active' ? 'bg-emerald-100 text-emerald-700' : 'bg-yellow-100 text-yellow-700' }}">
                            {{ ucfirst($patient->status ?? 'pending') }}
                        </span>
                    </td>
                    <td class="px-4 py-3.5 text-sm text-slate-700">
                        <div>{{ $patient->clinic->name ?? 'N/A' }}</div>
                        <div class="text-slate-500 text-xs mt-1">{{ $patient->schedule?->day_name ? $patient->schedule->day_name . ' ' . $patient->schedule->start_time . ' - ' . $patient->schedule->end_time : 'No schedule' }}</div>
                    </td>
                    <td class="px-4 py-3.5 text-sm text-slate-700">
                        @if($patient->appointment_id)
                            {{ $patient->appointment?->appointment_date?->format('d M Y') ?? 'N/A' }}
                        @else
                            <span class="inline-flex items-center rounded-full bg-red-50 text-red-700 px-2.5 py-1 text-[11px] font-semibold uppercase tracking-[0.16em]">No Appointment Yet</span>
                        @endif
                    </td>
                    <td class="px-4 py-3.5 text-sm text-slate-700">{{ $patient->prescription ? 'Prescription #' . $patient->prescription->id : 'N/A' }}</td>
                    <td class="px-4 py-3.5 text-sm text-slate-700">
                        <div class="flex gap-2 items-center">
                            <a href="{{ route('admin.appointments.create', ['patient_id' => $patient->id]) }}" class="px-3 py-2 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold transition-all duration-150">{{ $patient->appointment_id ? 'Re-appointment' : 'Make Appointment' }}</a>
                            <a href="{{ route('admin.patients.edit', $patient) }}" class="p-2 rounded-lg hover:bg-slate-100 text-slate-500 hover:text-slate-700 transition-all duration-150"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg></a>
                            <form action="{{ route('admin.patients.destroy', $patient) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 rounded-lg hover:bg-slate-100 text-red-500 hover:text-red-700 transition-all duration-150">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-4 py-8 text-center text-slate-500 text-sm">No patients found</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <div class="p-4">{{ $patients->links() }}</div>
</div>
@endsection
