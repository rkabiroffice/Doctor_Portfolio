@extends('layouts.admin')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-8 max-w-4xl">
    <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="grid md:grid-cols-2 gap-5">
            <div class="mb-5">
                <label class="block text-sm font-medium text-slate-700 mb-1.5">
                    Doctor Name <span class="text-red-500">*</span>
                </label>
                <input type="text" name="name" required value="{{ old('name', $profile->name) }}" class="w-full rounded-lg border @error('name') border-red-500 @else border-slate-200 @enderror bg-white px-3 py-2.5 text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-all duration-150">
                @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div class="mb-5">
                <label class="block text-sm font-medium text-slate-700 mb-1.5">
                    Specialty <span class="text-red-500">*</span>
                </label>
                <input type="text" name="specialty" required value="{{ old('specialty', $profile->specialty) }}" class="w-full rounded-lg border @error('specialty') border-red-500 @else border-slate-200 @enderror bg-white px-3 py-2.5 text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-all duration-150">
                @error('specialty')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div class="mb-5">
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Experience Years</label>
                <input type="number" name="experience_years" value="{{ old('experience_years', $profile->experience_years) }}" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-all duration-150">
            </div>
            <div class="mb-5">
                <label class="block text-sm font-medium text-slate-700 mb-1.5">CTA Text</label>
                <input type="text" name="cta_text" value="{{ old('cta_text', $profile->cta_text) }}" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-all duration-150">
            </div>
        </div>
        <div class="mb-5">
            <label class="block text-sm font-medium text-slate-700 mb-1.5">
                Hero Title <span class="text-red-500">*</span>
            </label>
            <input type="text" name="hero_title" required value="{{ old('hero_title', $profile->hero_title) }}" class="w-full rounded-lg border @error('hero_title') border-red-500 @else border-slate-200 @enderror bg-white px-3 py-2.5 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-all duration-150">
            @error('hero_title')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>
        <div class="mb-5">
            <label class="block text-sm font-medium text-slate-700 mb-1.5">Hero Subtitle</label>
            <textarea name="hero_subtitle" rows="3" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-all duration-150">{{ old('hero_subtitle', $profile->hero_subtitle) }}</textarea>
        </div>
        <div class="mb-5">
            <label class="block text-sm font-medium text-slate-700 mb-1.5">Bio</label>
            <textarea name="bio" rows="5" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-all duration-150">{{ old('bio', $profile->bio) }}</textarea>
        </div>
        <div class="grid md:grid-cols-2 gap-5">
            <div class="mb-5">
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Photo URL</label>
                <input type="url" name="photo_url" value="{{ old('photo_url', $profile->photo_url) }}" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-all duration-150">
            </div>
            <div class="mb-5">
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Upload Photo</label>
                <input type="file" name="photo_file" accept="image/*" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-all duration-150">
            </div>
            <div class="mb-5">
                <label class="block text-sm font-medium text-slate-700 mb-1.5">YouTube URL or Share Link</label>
                <input type="url" name="youtube_url" value="{{ old('youtube_url', $profile->youtube_url) }}" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-all duration-150">
            </div>
            <div class="mb-5">
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Upload Video File</label>
                <input type="file" name="video_file" accept="video/*" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-all duration-150">
                <p class="text-xs text-slate-500 mt-1">Upload MP4, WebM, MOV or AVI. Leave blank to keep the existing video or use the YouTube link.</p>
            </div>
            <div class="mb-5">
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Location Text</label>
                <input type="text" name="location_text" value="{{ old('location_text', $profile->location_text) }}" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-all duration-150">
            </div>
            <div class="mb-5">
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Contact Email</label>
                <input type="email" name="contact_email" value="{{ old('contact_email', $profile->contact_email) }}" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-all duration-150">
            </div>
            <div class="mb-5">
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Contact Phone</label>
                <input type="text" name="contact_phone" value="{{ old('contact_phone', $profile->contact_phone) }}" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-all duration-150">
            </div>
        </div>
        <button class="bg-orange-600 hover:bg-orange-700 text-white font-medium px-4 py-2 rounded-lg shadow-sm transition-all duration-150">Save Profile</button>
    </form>
</div>
@endsection
