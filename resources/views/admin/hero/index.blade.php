@extends('layouts.admin')

@section('content')
<div class="flex items-center justify-between mb-6 gap-4 flex-wrap">
    <form method="GET" class="flex items-center gap-3 flex-wrap">
        <input type="text" name="search" value="{{ $search }}" placeholder="Search hero sections..." class="w-72 rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-all duration-150">
        <button class="bg-white hover:bg-slate-50 text-slate-700 font-medium px-4 py-2 rounded-lg border border-slate-200 transition-all duration-150">Search</button>
    </form>
    <div class="flex items-center gap-2 flex-wrap">
        <div class="relative">
            <button onclick="document.getElementById('heroExportMenu').classList.toggle('hidden')" type="button" class="bg-emerald-600 hover:bg-emerald-700 text-white font-medium px-4 py-2 rounded-lg shadow-sm transition-all duration-150 inline-flex items-center gap-2">Export</button>
            <div id="heroExportMenu" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-slate-200 z-10">
                <a href="{{ route('admin.hero.export', 'csv') }}" class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 rounded-t-lg">CSV</a>
                <a href="{{ route('admin.hero.export', 'excel') }}" class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-50">Excel</a>
                <a href="{{ route('admin.hero.export', 'pdf') }}" class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 rounded-b-lg">PDF</a>
            </div>
        </div>
        <a href="{{ route('admin.hero.sample', 'csv') }}" class="bg-slate-100 hover:bg-slate-200 text-slate-700 font-medium px-4 py-2 rounded-lg transition-all duration-150">Sample CSV</a>
        <a href="{{ route('admin.hero.sample', 'excel') }}" class="bg-slate-100 hover:bg-slate-200 text-slate-700 font-medium px-4 py-2 rounded-lg transition-all duration-150">Sample Excel</a>
        <form action="{{ route('admin.hero.import') }}" method="POST" enctype="multipart/form-data" class="flex items-center gap-2">
            @csrf
            <label for="heroImportFile" class="cursor-pointer rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 transition-all duration-150">Choose File</label>
            <input id="heroImportFile" type="file" name="file" accept=".csv,.xls,.xlsx" class="hidden" required>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-4 py-2 rounded-lg transition-all duration-150">Import</button>
        </form>
        <a href="{{ route('admin.hero.create') }}" class="bg-orange-600 hover:bg-orange-700 text-white font-medium px-4 py-2 rounded-lg shadow-sm transition-all duration-150">Add New</a>
    </div>
</div>
<div class="bg-white rounded-2xl shadow-sm overflow-hidden border border-slate-100">
    <table class="min-w-full">
        <thead class="bg-slate-50 border-b border-slate-200">
            <tr>
                <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Title</th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Sort</th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Status</th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($heroSections as $section)
                <tr class="border-b border-slate-100 hover:bg-slate-50 transition-colors duration-100">
                    <td class="px-4 py-3.5 text-sm text-slate-700 font-medium">{{ \Illuminate\Support\Str::limit($section->title, 60) }}</td>
                    <td class="px-4 py-3.5 text-sm text-slate-700">{{ $section->sort_order }}</td>
                    <td class="px-4 py-3.5 text-sm text-slate-700"><span class="{{ $section->is_active ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-slate-100 text-slate-600 border border-slate-200' }} px-2.5 py-0.5 rounded-full text-xs font-medium">{{ $section->is_active ? 'Active' : 'Inactive' }}</span></td>
                    <td class="px-4 py-3.5 text-sm text-slate-700"><div class="flex gap-2 items-center"><a href="{{ route('admin.hero.edit', $section) }}" class="p-2 rounded-lg hover:bg-slate-100 text-slate-500 hover:text-slate-700 transition-all duration-150"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg></a><form action="{{ route('admin.hero.destroy', $section) }}" method="POST">@csrf @method('DELETE')<button class="p-2 rounded-lg hover:bg-slate-100 text-red-500 hover:text-red-700 transition-all duration-150"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg></button></form></div></td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="p-4">{{ $heroSections->links() }}</div>
</div>
@endsection
