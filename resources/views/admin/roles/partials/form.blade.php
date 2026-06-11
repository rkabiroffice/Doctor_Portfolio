<div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-8 max-w-3xl">
    <form action="{{ $action }}" method="POST">
        @csrf
        @if($method !== 'POST') @method($method) @endif
        <div class="mb-5"><label class="block text-sm font-medium text-slate-700 mb-1.5">Role Name</label><input type="text" name="name" value="{{ old('name', $role?->name) }}" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-all duration-150"></div>
        <div class="mb-5"><label class="block text-sm font-medium text-slate-700 mb-1.5">Description</label><textarea name="description" rows="4" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-all duration-150">{{ old('description', $role?->description) }}</textarea></div>
        <div class="mb-6">
            <label class="block text-sm font-medium text-slate-700 mb-3">Permissions</label>
            <div class="grid md:grid-cols-2 gap-3">
                @foreach($permissionOptions as $permission)
                    <label class="flex items-center gap-3 rounded-xl border border-slate-200 px-4 py-3 bg-slate-50">
                        <input type="checkbox" name="permissions[]" value="{{ $permission }}" {{ in_array($permission, old('permissions', $role?->permissions ?? [])) ? 'checked' : '' }} class="rounded border-slate-300 text-orange-600 focus:ring-orange-500">
                        <span class="text-sm text-slate-700">{{ $permission }}</span>
                    </label>
                @endforeach
            </div>
        </div>
        <button class="bg-orange-600 hover:bg-orange-700 text-white font-medium px-4 py-2 rounded-lg shadow-sm transition-all duration-150">Save Role</button>
    </form>
</div>
