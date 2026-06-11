<div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-8 max-w-2xl">
    <form action="{{ $action }}" method="POST">
        @csrf
        @if($method !== 'POST') @method($method) @endif
        <div class="mb-5"><label class="block text-sm font-medium text-slate-700 mb-1.5">Medicine Name</label><input type="text" name="name" value="{{ old('name', $medicine?->name) }}" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-all duration-150"></div>
        <div class="grid md:grid-cols-2 gap-5">
            <div class="mb-5"><label class="block text-sm font-medium text-slate-700 mb-1.5">Generic Name</label><input type="text" name="generic_name" value="{{ old('generic_name', $medicine?->generic_name) }}" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-all duration-150"></div>
            <div class="mb-5"><label class="block text-sm font-medium text-slate-700 mb-1.5">Strength</label><input type="text" name="strength" value="{{ old('strength', $medicine?->strength) }}" placeholder="e.g., 500mg" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-all duration-150"></div>
            <div class="mb-5"><label class="block text-sm font-medium text-slate-700 mb-1.5">Dosage Form</label><input type="text" name="dosage_form" value="{{ old('dosage_form', $medicine?->dosage_form) }}" placeholder="e.g., Tablet, Capsule" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-all duration-150"></div>
            <div class="mb-5"><label class="block text-sm font-medium text-slate-700 mb-1.5">Manufacturer</label><input type="text" name="manufacturer" value="{{ old('manufacturer', $medicine?->manufacturer) }}" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-all duration-150"></div>
        </div>
        <div class="mb-5"><label class="block text-sm font-medium text-slate-700 mb-1.5">Notes</label><textarea name="notes" rows="4" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-all duration-150">{{ old('notes', $medicine?->notes) }}</textarea></div>
        <button class="bg-orange-600 hover:bg-orange-700 text-white font-medium px-4 py-2 rounded-lg shadow-sm transition-all duration-150">Save Medicine</button>
    </form>
</div>
