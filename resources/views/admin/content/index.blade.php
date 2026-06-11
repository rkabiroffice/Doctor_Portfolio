@extends('layouts.admin')

@section('content')
<div class="flex items-center justify-between mb-6 gap-4 flex-wrap">
    <div class="text-slate-600">Manage content sections with import/export and sample templates.</div>
    <div class="flex items-center gap-2 flex-wrap">
        <div class="relative">
            <button onclick="document.getElementById('contentExportMenu').classList.toggle('hidden')" type="button" class="bg-emerald-600 hover:bg-emerald-700 text-white font-medium px-4 py-2 rounded-lg shadow-sm transition-all duration-150 inline-flex items-center gap-2">Export</button>
            <div id="contentExportMenu" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-slate-200 z-10">
                <a href="{{ route('admin.content-sections.export', 'csv') }}" class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 rounded-t-lg">CSV</a>
                <a href="{{ route('admin.content-sections.export', 'excel') }}" class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-50">Excel</a>
                <a href="{{ route('admin.content-sections.export', 'pdf') }}" class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 rounded-b-lg">PDF</a>
            </div>
        </div>
        <a href="{{ route('admin.content-sections.sample', 'csv') }}" class="bg-slate-100 hover:bg-slate-200 text-slate-700 font-medium px-4 py-2 rounded-lg transition-all duration-150">Sample CSV</a>
        <a href="{{ route('admin.content-sections.sample', 'excel') }}" class="bg-slate-100 hover:bg-slate-200 text-slate-700 font-medium px-4 py-2 rounded-lg transition-all duration-150">Sample Excel</a>
        <form action="{{ route('admin.content-sections.import') }}" method="POST" enctype="multipart/form-data" class="flex items-center gap-2">
            @csrf
            <label for="contentImportFile" class="cursor-pointer rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 transition-all duration-150">Choose File</label>
            <input id="contentImportFile" type="file" name="file" accept=".csv,.xls,.xlsx" class="hidden" required>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-4 py-2 rounded-lg transition-all duration-150">Import</button>
        </form>
    </div>
</div>
<div class="space-y-6">
    @foreach($contentSections as $key => $section)
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-8">
            <h2 class="text-lg font-semibold text-slate-900 mb-6">{{ $section->section_label }}</h2>
            <form action="{{ route('admin.content.update', $key) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="mb-5">
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Title</label>
                    <input type="text" name="title" value="{{ old('title', $section->title) }}" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-all duration-150">
                </div>
                <div class="mb-5">
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Subtitle</label>
                    <textarea name="subtitle" rows="3" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-all duration-150">{{ old('subtitle', $section->subtitle) }}</textarea>
                </div>
                <div class="mb-5">
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Content</label>
                    <textarea name="content" rows="5" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-all duration-150">{{ old('content', $section->content) }}</textarea>
                </div>
                @if($key === 'hero')
                    <div class="mb-5">
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Image URL</label>
                        <input type="url" name="image_url" value="{{ old('image_url', $section->image_url) }}" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-all duration-150">
                    </div>
                    <div class="mb-5">
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Upload Image</label>
                        <input type="file" name="image_file" accept="image/*" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-all duration-150">
                    </div>
                @endif
                <button class="bg-orange-600 hover:bg-orange-700 text-white font-medium px-4 py-2 rounded-lg shadow-sm transition-all duration-150">Update {{ $section->section_label }}</button>
            </form>
        </div>
    @endforeach
</div>
@endsection
