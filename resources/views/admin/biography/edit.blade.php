@extends('layouts.admin')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-8 max-w-3xl">
    <form action="{{ route('admin.biography.update', $biography) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mb-5"><label class="block text-sm font-medium text-slate-700 mb-1.5">Title</label><input type="text" name="title" value="{{ old('title', $biography->title) }}" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-all duration-150" required></div>
        <div class="mb-5"><label class="block text-sm font-medium text-slate-700 mb-1.5">Subtitle</label><input type="text" name="subtitle" value="{{ old('subtitle', $biography->subtitle) }}" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-all duration-150"></div>
        <div class="mb-5"><label class="block text-sm font-medium text-slate-700 mb-1.5">Content</label><textarea name="content" rows="8" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-all duration-150" required>{{ old('content', $biography->content) }}</textarea></div>
        <div class="grid md:grid-cols-2 gap-5">
            <div class="mb-5">
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Upload Video File</label>
                <input type="file" name="video_file" accept="video/*" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-all duration-150">
                <p class="text-xs text-slate-500 mt-1">Upload MP4, WebM, MOV or AVI. Leave blank to keep the existing video or use the YouTube link.</p>
            </div>
            <div class="mb-5"><label class="block text-sm font-medium text-slate-700 mb-1.5">YouTube URL</label><input type="url" name="youtube_url" value="{{ old('youtube_url', $biography->youtube_url) }}" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-all duration-150"></div>
        </div>
        <div class="grid md:grid-cols-2 gap-5">
            <div class="mb-5"><label class="block text-sm font-medium text-slate-700 mb-1.5">Sort Order</label><input type="number" name="sort_order" value="{{ old('sort_order', $biography->sort_order) }}" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-all duration-150" required></div>
            <div class="mb-5 flex items-center gap-3 pt-8"><input type="checkbox" name="is_active" value="1" {{ old('is_active', $biography->is_active) ? 'checked' : '' }} class="rounded border-slate-300 text-orange-600 focus:ring-orange-500"><label class="text-sm font-medium text-slate-700">Active</label></div>
        </div>
        <button class="bg-orange-600 hover:bg-orange-700 text-white font-medium px-4 py-2 rounded-lg shadow-sm transition-all duration-150">Update Biography</button>
    </form>
</div>
@endsection
