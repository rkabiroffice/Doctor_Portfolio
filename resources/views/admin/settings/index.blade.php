@extends('layouts.admin')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-8 max-w-3xl">
    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <h2 class="text-lg font-semibold text-slate-900 mb-6">Site Settings</h2>
        <div class="grid md:grid-cols-2 gap-5">
            <div class="mb-5">
                <label class="block text-sm font-medium text-slate-700 mb-1.5">
                    Site Name <span class="text-red-500">*</span>
                </label>
                <input type="text" name="site_name" required value="{{ old('site_name', $settings['site_name'] ?? '') }}" class="w-full rounded-lg border @error('site_name') border-red-500 @else border-slate-200 @enderror bg-white px-3 py-2.5 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-all duration-150">
                @error('site_name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div class="mb-5">
                <label class="block text-sm font-medium text-slate-700 mb-1.5">
                    Site Tagline <span class="text-red-500">*</span>
                </label>
                <input type="text" name="site_tagline" required value="{{ old('site_tagline', $settings['site_tagline'] ?? '') }}" class="w-full rounded-lg border @error('site_tagline') border-red-500 @else border-slate-200 @enderror bg-white px-3 py-2.5 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-all duration-150">
                @error('site_tagline')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
        </div>
        <div class="grid md:grid-cols-2 gap-5">
            <div class="mb-5"><label class="block text-sm font-medium text-slate-700 mb-1.5">Logo URL</label><input type="url" name="logo_url" value="{{ old('logo_url', $settings['logo_url'] ?? '') }}" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-all duration-150"></div>
            <div class="mb-5"><label class="block text-sm font-medium text-slate-700 mb-1.5">Logo File</label><input type="file" name="logo_file" accept="image/*" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-all duration-150"></div>
        </div>
        @if(!empty($settings['logo_url']))
            <div class="mb-5">
                <p class="text-sm font-medium text-slate-700 mb-2">Current Logo Preview</p>
                <img src="{{ $settings['logo_url'] }}" alt="Current logo" class="h-20 object-contain border border-slate-200 rounded-lg p-2 bg-white" />
            </div>
        @endif
        <div class="grid md:grid-cols-2 gap-5">
            <div class="mb-5">
                <label class="block text-sm font-medium text-slate-700 mb-1.5">
                    Logo Text <span class="text-red-500">*</span>
                </label>
                <input type="text" name="logo_text" required value="{{ old('logo_text', $settings['logo_text'] ?? 'Dr. Portfolio') }}" class="w-full rounded-lg border @error('logo_text') border-red-500 @else border-slate-200 @enderror bg-white px-3 py-2.5 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-all duration-150">
                @error('logo_text')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div class="mb-5"><label class="block text-sm font-medium text-slate-700 mb-1.5">Favicon URL</label><input type="url" name="favicon_url" value="{{ old('favicon_url', $settings['favicon_url'] ?? '') }}" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-all duration-150"></div>
        </div>
        <div class="grid md:grid-cols-2 gap-5">
            <div class="mb-5"><label class="block text-sm font-medium text-slate-700 mb-1.5">Favicon File</label><input type="file" name="favicon_file" accept="image/*" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-all duration-150"></div>
        </div>
        @if(!empty($settings['favicon_url']))
            <div class="mb-5">
                <p class="text-sm font-medium text-slate-700 mb-2">Current Favicon Preview</p>
                <img src="{{ $settings['favicon_url'] }}" alt="Current favicon" class="h-12 w-12 object-contain border border-slate-200 rounded-lg p-2 bg-white" />
            </div>
        @endif
        <div class="grid md:grid-cols-2 gap-5">
            <div class="mb-5"><label class="block text-sm font-medium text-slate-700 mb-1.5">Signature File</label><input type="file" name="signature_file" accept="image/*" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-all duration-150"></div>
            <div class="mb-5"><label class="block text-sm font-medium text-slate-700 mb-1.5">Stamp File</label><input type="file" name="stamp_file" accept="image/*" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-all duration-150"></div>
        </div>
        @if(!empty($settings['doctor_signature']) || !empty($settings['doctor_stamp']))
            <div class="grid md:grid-cols-2 gap-5 mb-5">
                @if(!empty($settings['doctor_signature']))
                    <div>
                        <p class="text-sm font-medium text-slate-700 mb-2">Current Signature</p>
                        <img src="{{ $settings['doctor_signature'] }}" alt="Current signature" class="max-h-28 w-full object-contain border border-slate-200 rounded-lg p-2 bg-white" />
                    </div>
                @endif
                @if(!empty($settings['doctor_stamp']))
                    <div>
                        <p class="text-sm font-medium text-slate-700 mb-2">Current Stamp</p>
                        <img src="{{ $settings['doctor_stamp'] }}" alt="Current stamp" class="max-h-28 w-full object-contain border border-slate-200 rounded-lg p-2 bg-white" />
                    </div>
                @endif
            </div>
        @endif
        <div class="border-t border-slate-200 pt-6 mt-6">
            <h3 class="text-base font-semibold text-slate-900 mb-5">Social Media Links</h3>
            @php
                $facebookPages = old('social_facebook_pages', json_decode($settings['social_facebook_pages'] ?? '[]', true) ?: ['']);
            @endphp
            <div class="mb-5">
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Facebook Page URLs</label>
                <div id="facebookPagesWrapper" class="space-y-3">
                    @foreach($facebookPages as $page)
                        <div class="flex gap-3 items-center">
                            <input type="url" name="social_facebook_pages[]" value="{{ $page }}" placeholder="Facebook page URL" class="flex-1 rounded-lg border @error('social_facebook_pages.*') border-red-500 @else border-slate-200 @enderror bg-white px-3 py-2.5 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-all duration-150">
                            <button type="button" onclick="removeFacebookPage(this)" class="inline-flex h-10 w-10 items-center justify-center rounded-lg border border-slate-200 bg-slate-50 text-slate-700 hover:bg-slate-100 transition-all duration-150">-</button>
                        </div>
                    @endforeach
                </div>
                @error('social_facebook_pages.*')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                <button type="button" onclick="addFacebookPage()" class="mt-3 inline-flex items-center gap-2 rounded-lg bg-orange-600 px-4 py-2 text-sm font-medium text-white hover:bg-orange-700 transition-all duration-150">+ Add Facebook Page</button>
            </div>
            <div class="grid md:grid-cols-2 gap-5">
                <div class="mb-5">
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Facebook URL</label>
                    <input type="url" name="social_facebook" value="{{ old('social_facebook', $settings['social_facebook'] ?? '') }}" class="w-full rounded-lg border @error('social_facebook') border-red-500 @else border-slate-200 @enderror bg-white px-3 py-2.5 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-all duration-150">
                    @error('social_facebook')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div class="mb-5">
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Twitter URL</label>
                    <input type="url" name="social_twitter" value="{{ old('social_twitter', $settings['social_twitter'] ?? '') }}" class="w-full rounded-lg border @error('social_twitter') border-red-500 @else border-slate-200 @enderror bg-white px-3 py-2.5 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-all duration-150">
                    @error('social_twitter')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div class="mb-5">
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Instagram URL</label>
                    <input type="url" name="social_instagram" value="{{ old('social_instagram', $settings['social_instagram'] ?? '') }}" class="w-full rounded-lg border @error('social_instagram') border-red-500 @else border-slate-200 @enderror bg-white px-3 py-2.5 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-all duration-150">
                    @error('social_instagram')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div class="mb-5">
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">LinkedIn URL</label>
                    <input type="url" name="social_linkedin" value="{{ old('social_linkedin', $settings['social_linkedin'] ?? '') }}" class="w-full rounded-lg border @error('social_linkedin') border-red-500 @else border-slate-200 @enderror bg-white px-3 py-2.5 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-all duration-150">
                    @error('social_linkedin')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div class="mb-5">
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">YouTube URL</label>
                    <input type="url" name="social_youtube" value="{{ old('social_youtube', $settings['social_youtube'] ?? '') }}" class="w-full rounded-lg border @error('social_youtube') border-red-500 @else border-slate-200 @enderror bg-white px-3 py-2.5 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-all duration-150">
                    @error('social_youtube')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div class="mb-5">
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">TikTok URL</label>
                    <input type="url" name="social_tiktok" value="{{ old('social_tiktok', $settings['social_tiktok'] ?? '') }}" class="w-full rounded-lg border @error('social_tiktok') border-red-500 @else border-slate-200 @enderror bg-white px-3 py-2.5 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-all duration-150">
                    @error('social_tiktok')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
            </div>
        </div>
        <div class="border-t border-slate-200 pt-6 mt-6">
            <h3 class="text-base font-semibold text-slate-900 mb-5">Brand Colors</h3>
            <div class="grid md:grid-cols-2 gap-5">
                <div class="mb-5">
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">
                        Primary Color <span class="text-red-500">*</span>
                    </label>
                    <input type="color" name="primary_color" required value="{{ old('primary_color', $settings['primary_color'] ?? '#f97316') }}" class="w-full rounded-lg border @error('primary_color') border-red-500 @else border-slate-200 @enderror bg-white px-3 py-2.5 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-all duration-150">
                    @error('primary_color')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div class="mb-5">
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Secondary Color</label>
                    <input type="color" name="secondary_color" value="{{ old('secondary_color', $settings['secondary_color'] ?? '#7c3aed') }}" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-all duration-150">
                </div>
            </div>
        </div>
        <div class="border-t border-slate-200 pt-6 mt-6">
            <h3 class="text-base font-semibold text-slate-900 mb-5">SEO & Footer</h3>
            <div class="mb-5">
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Meta Description</label>
                <textarea name="meta_description" rows="2" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-all duration-150">{{ old('meta_description', $settings['meta_description'] ?? '') }}</textarea>
            </div>
            <div class="mb-5">
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Meta Keywords</label>
                <textarea name="meta_keywords" rows="2" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-all duration-150">{{ old('meta_keywords', $settings['meta_keywords'] ?? '') }}</textarea>
            </div>
            <div class="mb-5">
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Footer Text</label>
                <textarea name="footer_text" rows="2" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-all duration-150">{{ old('footer_text', $settings['footer_text'] ?? '') }}</textarea>
            </div>
            <div class="mb-5">
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Top Notice Text</label>
                <textarea name="top_notice" rows="2" placeholder="Enter the scrolling notice text shown at the top of the site" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-all duration-150">{{ old('top_notice', $settings['top_notice'] ?? '') }}</textarea>
                <p class="text-xs text-slate-500 mt-1">This text appears in the auto-scrolling notice bar at the top of the public website.</p>
            </div>
        </div>
        
        <div class="flex gap-3 mt-8 pt-6 border-t border-slate-200">
            <button type="submit" class="inline-flex items-center gap-2 rounded-lg bg-orange-600 px-6 py-2.5 text-sm font-medium text-white hover:bg-orange-700 transition-all duration-150">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                Save Settings
            </button>
        </div>
    </form>
</div>

<script>
    function addFacebookPage() {
        const wrapper = document.getElementById('facebookPagesWrapper');
        const row = document.createElement('div');
        row.className = 'flex gap-3 items-center';
        row.innerHTML = '<input type="url" name="social_facebook_pages[]" placeholder="Facebook page URL" class="flex-1 rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-all duration-150">' +
            '<button type="button" onclick="removeFacebookPage(this)" class="inline-flex h-10 w-10 items-center justify-center rounded-lg border border-slate-200 bg-slate-50 text-slate-700 hover:bg-slate-100 transition-all duration-150">-</button>';
        wrapper.appendChild(row);
    }
    function removeFacebookPage(button) {
        const row = button.closest('div');
        if (!row) return;
        row.remove();
        const wrapper = document.getElementById('facebookPagesWrapper');
        if (wrapper.querySelectorAll('input[name="social_facebook_pages[]"]').length === 0) {
            addFacebookPage();
        }
    }
</script>

@endsection
