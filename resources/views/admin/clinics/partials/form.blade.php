<div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-8 max-w-2xl">
    <form action="{{ $action }}" method="POST">
        @csrf
        @if($method !== 'POST') @method($method) @endif
        <div class="mb-5">
            <label class="block text-sm font-medium text-slate-700 mb-1.5">Clinic Name</label>
            <input type="text" name="name" value="{{ old('name', $clinic?->name) }}" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-all duration-150">
        </div>
        <div class="mb-5">
            <label class="block text-sm font-medium text-slate-700 mb-1.5">Address</label>
            <textarea name="address" rows="4" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-all duration-150">{{ old('address', $clinic?->address) }}</textarea>
        </div>
        <div class="grid md:grid-cols-2 gap-5">
            <div class="mb-5">
                <label class="block text-sm font-medium text-slate-700 mb-1.5">City</label>
                <input type="text" name="city" value="{{ old('city', $clinic?->city) }}" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-all duration-150">
            </div>
            <div class="mb-5">
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Phone Numbers</label>
                <div id="phone-inputs-container" class="space-y-2">
                    @php
                        $phones = old('phones', $clinic?->phones ?? []);
                        if (!is_array($phones)) {
                            $phones = [];
                        }
                        $phones = !empty($phones) ? $phones : [''];
                    @endphp
                    @foreach($phones as $index => $phone)
                        <div class="flex gap-2 items-center" data-phone-index="{{ $index }}">
                            <input type="text" name="phones[]" value="{{ $phone }}" placeholder="Phone number" class="flex-1 rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-all duration-150">
                            <button type="button" class="btn-remove-phone px-3 py-2.5 bg-red-100 hover:bg-red-200 text-red-600 rounded-lg text-sm font-medium transition-all duration-150" @if($loop->count === 1) style="display:none;" @endif>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </div>
                    @endforeach
                </div>
                <button type="button" id="btn-add-phone" class="mt-3 px-4 py-2 bg-orange-100 hover:bg-orange-200 text-orange-600 rounded-lg text-sm font-medium transition-all duration-150">
                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Add Phone
                </button>
            </div>
        </div>
        <div class="mb-5">
            <label class="block text-sm font-medium text-slate-700 mb-1.5">Google Maps Share/Embed URL</label>
            <input type="url" name="map_embed_url" value="{{ old('map_embed_url', $clinic?->map_embed_url) }}" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-all duration-150">
            <p class="text-xs text-slate-500 mt-1">Paste a Google Maps share link from the browser or a valid iframe embed URL.</p>
        </div>
        <div class="mb-5 flex items-center gap-3">
            <input type="checkbox" name="is_active" value="1" {{ old('is_active', $clinic?->is_active ?? true) ? 'checked' : '' }} class="rounded border-slate-300 text-orange-600 focus:ring-orange-500">
            <label class="text-sm font-medium text-slate-700">Active clinic</label>
        </div>
        <button class="bg-orange-600 hover:bg-orange-700 text-white font-medium px-4 py-2 rounded-lg shadow-sm transition-all duration-150">Save Clinic</button>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const addPhoneBtn = document.getElementById('btn-add-phone');
    const phoneContainer = document.getElementById('phone-inputs-container');

    // Add phone input
    addPhoneBtn.addEventListener('click', function(e) {
        e.preventDefault();
        const newIndex = phoneContainer.children.length;
        const newInput = document.createElement('div');
        newInput.className = 'flex gap-2 items-center';
        newInput.innerHTML = `
            <input type="text" name="phones[]" placeholder="Phone number" class="flex-1 rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-all duration-150">
            <button type="button" class="btn-remove-phone px-3 py-2.5 bg-red-100 hover:bg-red-200 text-red-600 rounded-lg text-sm font-medium transition-all duration-150">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
            </button>
        `;
        phoneContainer.appendChild(newInput);
        
        // Attach remove listener
        newInput.querySelector('.btn-remove-phone').addEventListener('click', removePhone);
        updateRemoveButtons();
    });

    // Remove phone input
    function removePhone(e) {
        e.preventDefault();
        e.target.closest('.flex').remove();
        updateRemoveButtons();
    }

    // Update remove buttons visibility
    function updateRemoveButtons() {
        const removeButtons = document.querySelectorAll('.btn-remove-phone');
        removeButtons.forEach((btn, index) => {
            if (removeButtons.length === 1) {
                btn.style.display = 'none';
            } else {
                btn.style.display = 'block';
            }
        });
    }

    // Initial setup
    document.querySelectorAll('.btn-remove-phone').forEach(btn => {
        btn.addEventListener('click', removePhone);
    });
    updateRemoveButtons();
});
</script>
