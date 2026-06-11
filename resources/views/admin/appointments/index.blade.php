@extends('layouts.admin')

@section('content')
<div class="flex items-center justify-between mb-6 gap-4 flex-wrap">
    <form method="GET" class="flex items-center gap-3 flex-wrap">
        <input type="text" name="search" value="{{ $search }}" placeholder="Search patients..." class="w-72 rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-all duration-150">
        <select name="status" class="rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-all duration-150">
            <option value="">All status</option>
            @foreach(['pending', 'confirmed', 'completed', 'cancelled'] as $item)
                <option value="{{ $item }}" @selected($status == $item)>{{ ucfirst($item) }}</option>
            @endforeach
        </select>
        <button class="bg-white hover:bg-slate-50 text-slate-700 font-medium px-4 py-2 rounded-lg border border-slate-200 transition-all duration-150">Filter</button>
    </form>
    <div class="flex items-center gap-2 flex-wrap">
        <div class="relative">
            <button onclick="document.getElementById('exportMenu').classList.toggle('hidden')" type="button" class="bg-emerald-600 hover:bg-emerald-700 text-white font-medium px-4 py-2 rounded-lg shadow-sm transition-all duration-150 inline-flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Export
            </button>
            <div id="exportMenu" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-slate-200 z-10">
                <a href="{{ route('admin.appointments.export', 'csv') }}" class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 rounded-t-lg">Export as CSV</a>
                <a href="{{ route('admin.appointments.export', 'excel') }}" class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-50">Export as Excel</a>
                <a href="{{ route('admin.appointments.export', 'pdf') }}" class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 rounded-b-lg">Export as PDF</a>
            </div>
        </div>
        <a href="{{ route('admin.appointments.sample', 'csv') }}" class="bg-slate-100 hover:bg-slate-200 text-slate-700 font-medium px-4 py-2 rounded-lg transition-all duration-150">Sample CSV</a>
        <a href="{{ route('admin.appointments.sample', 'excel') }}" class="bg-slate-100 hover:bg-slate-200 text-slate-700 font-medium px-4 py-2 rounded-lg transition-all duration-150">Sample Excel</a>
        <form action="{{ route('admin.appointments.import') }}" method="POST" enctype="multipart/form-data" class="flex items-center gap-2">
            @csrf
            <label for="appointmentImportFile" class="cursor-pointer rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 transition-all duration-150">Upload File</label>
            <input id="appointmentImportFile" type="file" name="file" accept=".csv,.xls,.xlsx" class="hidden" required>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-4 py-2 rounded-lg transition-all duration-150">Import</button>
        </form>
    </div>
</div>
<div class="bg-white rounded-2xl shadow-sm overflow-hidden border border-slate-100">
    <table class="min-w-full">
        <thead class="bg-slate-50 border-b border-slate-200">
            <tr>
                <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Patient ID</th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Patient</th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Clinic</th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Date & Time</th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Status</th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($appointments as $appointment)
                <tr class="border-b border-slate-100 hover:bg-slate-50 transition-colors duration-100">
                    <td class="px-4 py-3.5 text-sm text-slate-700 font-medium">{{ $appointment->patient?->id ? '#' . $appointment->patient->id : 'Unlinked' }}</td>
                    <td class="px-4 py-3.5 text-sm text-slate-700">
                        <div class="font-medium">{{ $appointment->patient_name }}</div>
                        <div class="text-slate-500 text-xs mt-1">{{ $appointment->phone }}</div>
                        @if($appointment->patient)
                            <a href="{{ route('admin.patients.edit', $appointment->patient) }}" class="text-sky-600 hover:text-sky-800 text-xs mt-1 inline-block">View patient record</a>
                        @endif
                    </td>
                    <td class="px-4 py-3.5 text-sm text-slate-700">{{ $appointment->clinic->name ?? 'N/A' }}</td>
                    <td class="px-4 py-3.5 text-sm text-slate-700">{{ $appointment->appointment_date->format('d M Y') }}<div class="text-slate-500 text-xs mt-1">{{ date('g:i A', strtotime($appointment->appointment_time)) }}</div></td>
                    <td class="px-4 py-3.5 text-sm text-slate-700"><span class="{{ $appointment->status === 'confirmed' || $appointment->status === 'completed' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : ($appointment->status === 'pending' ? 'bg-amber-50 text-amber-700 border border-amber-200' : 'bg-red-50 text-red-700 border border-red-200') }} px-2.5 py-0.5 rounded-full text-xs font-medium">{{ ucfirst($appointment->status) }}</span></td>
                    <td class="px-4 py-3.5 text-sm text-slate-700"><div class="flex gap-2 items-center"><a href="{{ route('admin.appointments.show', $appointment) }}" class="p-2 rounded-lg hover:bg-slate-100 text-slate-500 hover:text-slate-700 transition-all duration-150"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg></a><form action="{{ route('admin.appointments.destroy', $appointment) }}" method="POST">@csrf @method('DELETE')<button class="p-2 rounded-lg hover:bg-slate-100 text-red-500 hover:text-red-700 transition-all duration-150"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg></button></form></div></td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-4 py-8 text-center text-slate-500 text-sm">No appointments found</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <div class="p-4">{{ $appointments->links() }}</div>
</div>
@endsection
