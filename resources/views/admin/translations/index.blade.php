@extends('layouts.admin')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold text-slate-900">Translations</h1>
        <p class="text-sm text-slate-500 mt-1">Manage English to Bangla frontend translations for the public site.</p>
    </div>
    <a href="{{ route('admin.translations.create') }}" class="inline-flex items-center gap-2 rounded-lg bg-brand-600 px-4 py-2 text-sm font-medium text-white hover:bg-brand-700 transition-all duration-150">+ Add Translation</a>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-slate-200">
            <thead class="bg-slate-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Source Text</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Bangla Text</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Language</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Context</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Active</th>
                    <th class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wide text-slate-500">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200 bg-white">
                @forelse($translations as $translation)
                    <tr>
                        <td class="px-4 py-4 text-sm text-slate-700">{{ \Illuminate\Support\Str::limit($translation->source_text, 80) }}</td>
                        <td class="px-4 py-4 text-sm text-slate-700">{{ \Illuminate\Support\Str::limit($translation->translated_text, 80) }}</td>
                        <td class="px-4 py-4 text-sm text-slate-700">{{ strtoupper($translation->language) }}</td>
                        <td class="px-4 py-4 text-sm text-slate-700">{{ $translation->context ?? '—' }}</td>
                        <td class="px-4 py-4 text-sm text-slate-700">{{ $translation->is_active ? 'Yes' : 'No' }}</td>
                        <td class="px-4 py-4 text-right text-sm font-medium">
                            <a href="{{ route('admin.translations.edit', $translation) }}" class="text-brand-600 hover:underline">Edit</a>
                            <form action="{{ route('admin.translations.destroy', $translation) }}" method="POST" class="inline-block ml-3" onsubmit="return confirm('Delete this translation?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-10 text-center text-sm text-slate-500">No translations found. Add the first translation to enable frontend page translation.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="border-t border-slate-200 px-4 py-4 bg-slate-50">
        {{ $translations->links() }}
    </div>
</div>
@endsection
