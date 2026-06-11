@extends('layouts.admin')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-8 max-w-3xl">
    <form action="{{ route('admin.hero.update', $heroSection) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mb-5"><label class="block text-sm font-medium text-slate-700 mb-1.5">Title</label><input type="text" name="title" value="{{ old('title', $heroSection->title) }}" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-all duration-150" required></div>
        <div class="mb-5"><label class="block text-sm font-medium text-slate-700 mb-1.5">Subtitle</label><textarea name="subtitle" rows="3" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-all duration-150">{{ old('subtitle', $heroSection->subtitle) }}</textarea></div>
        <div class="grid md:grid-cols-2 gap-5">
            <div class="mb-5"><label class="block text-sm font-medium text-slate-700 mb-1.5">Button Text</label><input type="text" name="button_text" value="{{ old('button_text', $heroSection->button_text) }}" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-all duration-150"></div>
            <div class="mb-5"><label class="block text-sm font-medium text-slate-700 mb-1.5">Button Link</label><input type="text" name="button_link" value="{{ old('button_link', $heroSection->button_link) }}" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-all duration-150"></div>
        </div>
        <div class="mb-5"><label class="block text-sm font-medium text-slate-700 mb-1.5">Image URL</label><input type="url" name="image_url" value="{{ old('image_url', $heroSection->image_url) }}" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-all duration-150"></div>
        @if(!empty($heroSection->image_url))
            <div class="mb-5">
                <p class="text-sm font-medium text-slate-700 mb-1.5">Current Image Preview</p>
                <img src="{{ $heroSection->image_url }}" alt="Hero image preview" class="w-full max-h-36 object-contain rounded-lg border border-slate-200 bg-white p-2" />
            </div>
        @endif
        <div class="mb-5"><label class="block text-sm font-medium text-slate-700 mb-1.5">Upload Image</label><input type="file" name="image_file" accept="image/*" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-all duration-150"></div>
        <div class="grid md:grid-cols-2 gap-5">
            <div class="mb-5"><label class="block text-sm font-medium text-slate-700 mb-1.5">Sort Order</label><input type="number" name="sort_order" value="{{ old('sort_order', $heroSection->sort_order) }}" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-all duration-150" required></div>
            <div class="mb-5 flex items-center gap-3 pt-8"><input type="checkbox" name="is_active" value="1" {{ old('is_active', $heroSection->is_active) ? 'checked' : '' }} class="rounded border-slate-300 text-orange-600 focus:ring-orange-500"><label class="text-sm font-medium text-slate-700">Active</label></div>
        </div>
        <button class="bg-orange-600 hover:bg-orange-700 text-white font-medium px-4 py-2 rounded-lg shadow-sm transition-all duration-150">Update Hero Section</button>
    </form>
</div>
@endsection
