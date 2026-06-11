@extends('layouts.admin')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-8 max-w-3xl">
    <form action="{{ route('admin.about.update', $aboutSection) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mb-5"><label class="block text-sm font-medium text-slate-700 mb-1.5">Title</label><input type="text" name="title" value="{{ old('title', $aboutSection->title) }}" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-all duration-150" required></div>
        <div class="mb-5"><label class="block text-sm font-medium text-slate-700 mb-1.5">Subtitle</label><textarea name="subtitle" rows="3" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-all duration-150">{{ old('subtitle', $aboutSection->subtitle) }}</textarea></div>
        <div class="mb-5"><label class="block text-sm font-medium text-slate-700 mb-1.5">Content</label><textarea name="content" rows="6" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-all duration-150" required>{{ old('content', $aboutSection->content) }}</textarea></div>
        <div class="mb-5"><label class="block text-sm font-medium text-slate-700 mb-1.5">Image URL</label><input type="url" name="image_url" value="{{ old('image_url', $aboutSection->image_url) }}" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-all duration-150"></div>
        @if(!empty($aboutSection->image_url))
            <div class="mb-5">
                <p class="text-sm font-medium text-slate-700 mb-1.5">Current Image Preview</p>
                <img src="{{ $aboutSection->image_url }}" alt="About section image preview" class="w-full max-h-36 object-contain rounded-lg border border-slate-200 bg-white p-2" />
            </div>
        @endif
        <div class="mb-5"><label class="block text-sm font-medium text-slate-700 mb-1.5">Upload Image</label><input type="file" name="image_file" accept="image/*" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-all duration-150"></div>
        <div class="grid md:grid-cols-2 gap-5">
            <div class="mb-5"><label class="block text-sm font-medium text-slate-700 mb-1.5">Sort Order</label><input type="number" name="sort_order" value="{{ old('sort_order', $aboutSection->sort_order) }}" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-all duration-150" required></div>
            <div class="mb-5 flex items-center gap-3 pt-8"><input type="checkbox" name="is_active" value="1" {{ old('is_active', $aboutSection->is_active) ? 'checked' : '' }} class="rounded border-slate-300 text-orange-600 focus:ring-orange-500"><label class="text-sm font-medium text-slate-700">Active</label></div>
        </div>
        <button class="bg-orange-600 hover:bg-orange-700 text-white font-medium px-4 py-2 rounded-lg shadow-sm transition-all duration-150">Update About Section</button>
    </form>
</div>
@endsection
