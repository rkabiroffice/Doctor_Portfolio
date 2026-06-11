<div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-8 max-w-2xl">
    <form action="{{ $action }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if($method !== 'POST') @method($method) @endif
        <div class="mb-5">
            <label class="block text-sm font-medium text-slate-700 mb-1.5">
                Title <span class="text-red-500">*</span>
            </label>
            <input type="text" name="title" required value="{{ old('title', $blog?->title) }}" class="w-full rounded-lg border @error('title') border-red-500 @else border-slate-200 @enderror bg-white px-3 py-2.5 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-all duration-150">
            @error('title')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>
        <div class="mb-5">
            <label class="block text-sm font-medium text-slate-700 mb-1.5">
                Excerpt <span class="text-red-500">*</span>
            </label>
            <textarea name="excerpt" required rows="3" class="w-full rounded-lg border @error('excerpt') border-red-500 @else border-slate-200 @enderror bg-white px-3 py-2.5 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-all duration-150">{{ old('excerpt', $blog?->excerpt) }}</textarea>
            @error('excerpt')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>
        <div class="mb-5">
            <label class="block text-sm font-medium text-slate-700 mb-1.5">
                Content <span class="text-red-500">*</span>
            </label>
            <textarea name="content" required rows="6" class="w-full rounded-lg border @error('content') border-red-500 @else border-slate-200 @enderror bg-white px-3 py-2.5 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-all duration-150">{{ old('content', $blog?->content) }}</textarea>
            @error('content')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>
        <div class="grid md:grid-cols-2 gap-5">
            <div class="mb-5"><label class="block text-sm font-medium text-slate-700 mb-1.5">YouTube URL or Share Link</label><input type="url" name="youtube_url" value="{{ old('youtube_url', $blog?->youtube_url) }}" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-all duration-150"></div>
            <div class="mb-5"><label class="block text-sm font-medium text-slate-700 mb-1.5">Image URL</label><input type="url" name="image_url" value="{{ old('image_url', $blog?->image_url) }}" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-all duration-150"></div>
        </div>
        @if(!empty($blog?->image_url))
            <div class="mb-5">
                <p class="text-sm font-medium text-slate-700 mb-1.5">Current Image Preview</p>
                <img src="{{ $blog->image_url }}" alt="Blog image preview" class="w-full max-h-36 object-contain rounded-lg border border-slate-200 bg-white p-2" />
            </div>
        @endif
        <div class="mb-5"><label class="block text-sm font-medium text-slate-700 mb-1.5">Upload Image</label><input type="file" name="image_file" accept="image/*" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-all duration-150"></div>
        <div class="mb-5"><label class="block text-sm font-medium text-slate-700 mb-1.5">Sort Order</label><input type="number" name="sort_order" value="{{ old('sort_order', $blog?->sort_order ?? 0) }}" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-all duration-150"></div>
        <div class="mb-5 flex items-center gap-3"><input type="checkbox" name="is_published" value="1" {{ old('is_published', $blog?->is_published ?? true) ? 'checked' : '' }} class="rounded border-slate-300 text-orange-600 focus:ring-orange-500"><label class="text-sm font-medium text-slate-700">Publish blog</label></div>
        <button class="bg-orange-600 hover:bg-orange-700 text-white font-medium px-4 py-2 rounded-lg shadow-sm transition-all duration-150">Save Blog</button>
    </form>
</div>
