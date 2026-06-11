<div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-8 max-w-2xl">
    <form action="{{ $action }}" method="POST">
        @csrf
        @if($method !== 'POST') @method($method) @endif
        <div class="mb-5">
            <label class="block text-sm font-medium text-slate-700 mb-1.5">Patient Name</label>
            <input type="text" name="patient_name" value="{{ old('patient_name', $review?->patient_name) }}" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-all duration-150">
        </div>
        <div class="grid md:grid-cols-2 gap-5">
            <div class="mb-5">
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Designation</label>
                <input type="text" name="designation" value="{{ old('designation', $review?->designation) }}" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-all duration-150">
            </div>
            <div class="mb-5">
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Rating</label>
                <input type="number" min="1" max="5" name="rating" value="{{ old('rating', $review?->rating ?? 5) }}" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-all duration-150">
            </div>
        </div>
        <div class="mb-5">
            <label class="block text-sm font-medium text-slate-700 mb-1.5">Review Text</label>
            <textarea name="review_text" rows="5" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-all duration-150">{{ old('review_text', $review?->review_text) }}</textarea>
        </div>
        <div class="mb-5 flex items-center gap-3">
            <input type="checkbox" name="is_published" value="1" {{ old('is_published', $review?->is_published ?? true) ? 'checked' : '' }} class="rounded border-slate-300 text-orange-600 focus:ring-orange-500">
            <label class="text-sm font-medium text-slate-700">Publish review</label>
        </div>
        <button class="bg-orange-600 hover:bg-orange-700 text-white font-medium px-4 py-2 rounded-lg shadow-sm transition-all duration-150">Save Review</button>
    </form>
</div>
