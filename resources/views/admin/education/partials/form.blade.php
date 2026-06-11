<div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-8 max-w-2xl">
    <form action="{{ $action }}" method="POST">
        @csrf
        @if($method !== 'POST') @method($method) @endif
        <div class="mb-5">
            <label class="block text-sm font-medium text-slate-700 mb-1.5">
                Degree / Certification <span class="text-red-500">*</span>
            </label>
            <input type="text" name="degree" required value="{{ old('degree', $education?->degree) }}" class="w-full rounded-lg border @error('degree') border-red-500 @else border-slate-200 @enderror bg-white px-3 py-2.5 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-all duration-150">
            @error('degree')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>
        <div class="mb-5">
            <label class="block text-sm font-medium text-slate-700 mb-1.5">
                Institution <span class="text-red-500">*</span>
            </label>
            <input type="text" name="institution" required value="{{ old('institution', $education?->institution) }}" class="w-full rounded-lg border @error('institution') border-red-500 @else border-slate-200 @enderror bg-white px-3 py-2.5 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-all duration-150">
            @error('institution')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>
        <div class="grid md:grid-cols-2 gap-5">
            <div class="mb-5">
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Year Completed</label>
                <input type="number" name="year_completed" value="{{ old('year_completed', $education?->year_completed) }}" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-all duration-150">
            </div>
            <div class="mb-5">
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Type</label>
                <input type="text" name="type" value="{{ old('type', $education?->type ?? 'Education') }}" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-all duration-150">
            </div>
        </div>
        <div class="mb-5">
            <label class="block text-sm font-medium text-slate-700 mb-1.5">Details</label>
            <textarea name="details" rows="4" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-all duration-150">{{ old('details', $education?->details) }}</textarea>
        </div>
        <button class="bg-orange-600 hover:bg-orange-700 text-white font-medium px-4 py-2 rounded-lg shadow-sm transition-all duration-150">Save Credential</button>
    </form>
</div>
        <div class="grid md:grid-cols-2 gap-5">
            <div class="mb-5">
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Year Completed</label>
                <input type="number" name="year_completed" value="{{ old('year_completed', $education?->year_completed) }}" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-all duration-150">
            </div>
            <div class="mb-5">
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Type</label>
                <input type="text" name="type" value="{{ old('type', $education?->type ?? 'Education') }}" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-all duration-150">
            </div>
        </div>
        <div class="mb-5">
            <label class="block text-sm font-medium text-slate-700 mb-1.5">Details</label>
            <textarea name="details" rows="4" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-all duration-150">{{ old('details', $education?->details) }}</textarea>
        </div>
        <button class="bg-orange-600 hover:bg-orange-700 text-white font-medium px-4 py-2 rounded-lg shadow-sm transition-all duration-150">Save Credential</button>
    </form>
</div>
