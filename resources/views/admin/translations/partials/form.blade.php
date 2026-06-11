<div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-8 max-w-3xl">
    <h2 class="text-lg font-semibold text-slate-900 mb-6">{{ $title ?? 'Translation' }}</h2>
    <div class="grid gap-5">
        <div class="mb-5">
            <label class="block text-sm font-medium text-slate-700 mb-1.5">Source Text (English) <span class="text-red-500">*</span></label>
            <textarea name="source_text" rows="4" required class="w-full rounded-lg border @error('source_text') border-red-500 @else border-slate-200 @enderror bg-white px-3 py-2.5 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-all duration-150">{{ old('source_text', $translation->source_text ?? '') }}</textarea>
            @error('source_text')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="mb-5">
            <label class="block text-sm font-medium text-slate-700 mb-1.5">Translated Text (Bangla) <span class="text-red-500">*</span></label>
            <textarea name="translated_text" rows="4" required class="w-full rounded-lg border @error('translated_text') border-red-500 @else border-slate-200 @enderror bg-white px-3 py-2.5 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-all duration-150">{{ old('translated_text', $translation->translated_text ?? '') }}</textarea>
            @error('translated_text')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="grid md:grid-cols-2 gap-5">
            <div class="mb-5">
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Language <span class="text-red-500">*</span></label>
                <select name="language" required class="w-full rounded-lg border @error('language') border-red-500 @else border-slate-200 @enderror bg-white px-3 py-2.5 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-all duration-150">
                    <option value="bn" @selected(old('language', $translation->language ?? 'bn') === 'bn')>Bangla</option>
                </select>
                @error('language')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div class="mb-5">
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Context</label>
                <input type="text" name="context" value="{{ old('context', $translation->context ?? '') }}" placeholder="Section name, button label, etc." class="w-full rounded-lg border @error('context') border-red-500 @else border-slate-200 @enderror bg-white px-3 py-2.5 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-all duration-150">
                @error('context')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
        </div>

        <div class="flex items-center gap-3">
            <label class="inline-flex items-center gap-2 text-sm text-slate-700">
                <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $translation->is_active ?? true)) class="rounded border-slate-300 text-orange-600 focus:ring-orange-500">
                <span>Active translation</span>
            </label>
        </div>

        <div class="flex gap-3 mt-6 pt-6 border-t border-slate-200">
            <button type="submit" class="inline-flex items-center gap-2 rounded-lg bg-orange-600 px-6 py-2.5 text-sm font-medium text-white hover:bg-orange-700 transition-all duration-150">Save Translation</button>
            <a href="{{ route('admin.translations.index') }}" class="inline-flex items-center gap-2 rounded-lg bg-slate-100 px-6 py-2.5 text-sm font-medium text-slate-700 hover:bg-slate-200 transition-all duration-150">Cancel</a>
        </div>
    </div>
</div>
