@extends('layouts.admin')

@section('content')
<div class="grid md:grid-cols-2 xl:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm">
        <div class="w-10 h-10 rounded-xl bg-orange-50 flex items-center justify-center mb-4"><svg class="inline w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg></div>
        <p class="text-sm text-slate-500 font-medium">Total Appointments</p>
        <p class="text-3xl font-bold text-slate-900 mt-1">{{ $stats['appointments'] }}</p>
        <p class="text-xs font-medium text-emerald-600 mt-2">↑ Active patient demand</p>
    </div>
    <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm">
        <div class="w-10 h-10 rounded-xl bg-amber-50 flex items-center justify-center mb-4"><svg class="inline w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg></div>
        <p class="text-sm text-slate-500 font-medium">Pending Requests</p>
        <p class="text-3xl font-bold text-slate-900 mt-1">{{ $stats['pending_appointments'] }}</p>
        <p class="text-xs font-medium text-amber-600 mt-2">Review and confirm quickly</p>
    </div>
    <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm">
        <div class="w-10 h-10 rounded-xl bg-violet-50 flex items-center justify-center mb-4"><svg class="inline w-5 h-5 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg></div>
        <p class="text-sm text-slate-500 font-medium">Clinic Locations</p>
        <p class="text-3xl font-bold text-slate-900 mt-1">{{ $stats['clinics'] }}</p>
        <p class="text-xs font-medium text-violet-600 mt-2">Across your two chambers</p>
    </div>
    <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm">
        <div class="w-10 h-10 rounded-xl bg-emerald-50 flex items-center justify-center mb-4"><svg class="inline w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M12 12a5 5 0 100-10 5 5 0 000 10z"/></svg></div>
        <p class="text-sm text-slate-500 font-medium">Prescriptions</p>
        <p class="text-3xl font-bold text-slate-900 mt-1">{{ $stats['prescriptions'] }}</p>
        <p class="text-xs font-medium text-emerald-600 mt-2">↑ Clinical documentation growing</p>
    </div>
</div>

<div class="grid md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm">
        <p class="text-sm text-slate-500 font-medium">Dynamic Sections</p>
        <p class="text-3xl font-bold text-slate-900 mt-1">{{ $stats['sections'] }}</p>
        <p class="text-xs font-medium text-orange-600 mt-2">Independent content blocks</p>
    </div>
    <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm">
        <p class="text-sm text-slate-500 font-medium">Published Blogs</p>
        <p class="text-3xl font-bold text-slate-900 mt-1">{{ $stats['blogs'] }}</p>
        <p class="text-xs font-medium text-violet-600 mt-2">Educational media and updates</p>
    </div>
    <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm">
        <p class="text-sm text-slate-500 font-medium">Roles</p>
        <p class="text-3xl font-bold text-slate-900 mt-1">{{ $stats['roles'] }}</p>
        <p class="text-xs font-medium text-emerald-600 mt-2">Admin-controlled permissions</p>
    </div>
</div>

<div class="bg-white rounded-2xl shadow-sm overflow-hidden border border-slate-100">
    <div class="p-6 border-b border-slate-100 flex items-center justify-between">
        <div>
            <h2 class="text-lg font-semibold text-slate-700">Recent Appointments</h2>
            <p class="text-sm text-slate-600 mt-1">Latest booking activity from both clinics.</p>
        </div>
        <a href="{{ route('admin.appointments.index') }}" class="bg-white hover:bg-slate-50 text-slate-700 font-medium px-4 py-2 rounded-lg border border-slate-200 transition-all duration-150">View all</a>
    </div>
    <table class="min-w-full">
        <thead class="bg-slate-50 border-b border-slate-200">
            <tr>
                <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Patient</th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Clinic</th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Date</th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Status</th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($recentAppointments as $appointment)
                <tr class="border-b border-slate-100 hover:bg-slate-50 transition-colors duration-100">
                    <td class="px-4 py-3.5 text-sm text-slate-700">{{ $appointment->patient_name }}</td>
                    <td class="px-4 py-3.5 text-sm text-slate-700">{{ $appointment->clinic->name ?? 'N/A' }}</td>
                    <td class="px-4 py-3.5 text-sm text-slate-700">{{ $appointment->appointment_date->format('d M Y') }}</td>
                    <td class="px-4 py-3.5 text-sm text-slate-700"><span class="{{ $appointment->status === 'confirmed' || $appointment->status === 'completed' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : ($appointment->status === 'pending' ? 'bg-amber-50 text-amber-700 border border-amber-200' : 'bg-red-50 text-red-700 border border-red-200') }} px-2.5 py-0.5 rounded-full text-xs font-medium">{{ ucfirst($appointment->status) }}</span></td>
                    <td class="px-4 py-3.5 text-sm text-slate-700"><a href="{{ route('admin.appointments.show', $appointment) }}" class="inline-flex gap-2 items-center text-orange-700 hover:text-orange-800 font-medium"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>View</a></td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
