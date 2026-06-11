<div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-8 max-w-2xl">
    <form action="{{ $action }}" method="POST">
        @csrf
        @if($method !== 'POST') @method($method) @endif
        <div class="mb-5">
            <label class="block text-sm font-medium text-slate-700 mb-1.5">Title</label>
            <input type="text" name="title" value="{{ old('title', $service?->title) }}" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-all duration-150">
        </div>
        <div class="mb-5">
            <label class="block text-sm font-medium text-slate-700 mb-1.5">Description</label>
            <textarea name="description" rows="4" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-all duration-150">{{ old('description', $service?->description) }}</textarea>
        </div>
        <div class="grid md:grid-cols-2 gap-5">
            <div class="mb-5">
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Icon</label>
                <input type="text" name="icon" value="{{ old('icon', $service?->icon ?? 'heart') }}" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-all duration-150">
            </div>
            <div class="mb-5">
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Sort Order</label>
                <input type="number" name="sort_order" value="{{ old('sort_order', $service?->sort_order ?? 0) }}" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-all duration-150">
            </div>
        </div>
        <div class="mb-5 flex items-center gap-3">
            <input type="checkbox" name="is_active" value="1" {{ old('is_active', $service?->is_active ?? true) ? 'checked' : '' }} class="rounded border-slate-300 text-orange-600 focus:ring-orange-500">
            <label class="text-sm font-medium text-slate-700">Active service</label>
        </div>
        <button class="bg-orange-600 hover:bg-orange-700 text-white font-medium px-4 py-2 rounded-lg shadow-sm transition-all duration-150">Save Service</button>
    </form>
</div>
