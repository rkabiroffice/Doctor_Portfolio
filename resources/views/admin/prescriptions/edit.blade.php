@extends('layouts.admin')

@section('content')
<div class="container mx-auto py-8">
    <form action="{{ route('admin.prescriptions.update', $prescription->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <input type="hidden" name="appointment_id" value="{{ $prescription->appointment_id }}">
        
        <div class="bg-white shadow-lg mx-auto w-full max-w-[850px] border border-gray-200 flex flex-col relative text-slate-800 rounded-sm" style="font-family: Arial, sans-serif;">
            
            <div class="flex justify-between items-start pt-8 pb-4 px-8">
                <div class="w-2/5">
                    <h2 class="text-2xl font-bold text-[#1e3a8a] mb-1" style="font-family: 'SolaimanLipi', serif;">ডাঃ মোঃ রায়হান উদ্দিন</h2>
                    <p class="text-xs font-semibold leading-tight text-slate-700">এমবিবিএস (সি.ইউ), ডিডি (ইউ.কে)<br>ডিভিএস (চর্ম ও যৌন)</p>
                    <p class="text-[10px] leading-tight text-slate-600 mt-1">
                        সিসিডি (বারডেম-ডায়াবেটিস)<br>
                        এফসিজিপি (ফ্যামিলি মেডিসিন)<br>
                        পিজিটি (মেডিসিন)<br>
                        ঢাকা মেডিকেল কলেজ ও হাসপাতাল<br>
                        ট্রেইন্ড ইন এস্থেটিকস, লেজার, হেয়ার ট্রান্সপ্লান্ট এন্ড ডার্মাটোসার্জারী<br>
                        মাস্টার্স ইন মেল (Male) ইনফার্টিলিটি (ইউএসএ)<br>
                        ফেলোশীপ ইন সেক্সুয়াল মেডিসিন (চেন্নাই, ইন্ডিয়া)।<br>
                        বিএমডিসি রেজিঃ <strong>A-81796</strong>
                    </p>
                </div>

                <div class="w-1/5 text-center flex flex-col items-center border-x-2 border-transparent">
                    <div class="border-2 border-[#1e3a8a] rounded-full px-3 py-1 mb-1 shadow-sm">
                        <p class="text-xs font-bold text-[#1e3a8a]">সিরিয়ালের জন্য :</p>
                    </div>
                    <p class="text-sm font-bold text-red-600 leading-tight">01647-386185<br>01727-375664</p>
                    <p class="text-[10px] text-slate-600">(সকাল ১১ টা - দুপুর ৩ টা পর্যন্ত)</p>
                    
                    <div class="border border-dashed border-red-500 bg-red-50/30 rounded-lg p-1 mt-2 w-full">
                        <p class="text-xs font-bold text-red-600 border-b border-red-200 pb-1 mb-1">রোগী দেখার সময় :</p>
                        <p class="text-[10px] text-slate-600 leading-tight">প্রতি বৃহস্পতি, শুক্র ও শনিবার<br>(দুপুর ২টা থেকে রাত ১০টা পর্যন্ত)</p>
                    </div>
                    <p class="text-[9px] mt-2 text-slate-500">চেম্বারে আসার পূর্বে ফোনে যোগাযোগ করে আসবেন।</p>
                </div>

                <div class="w-2/5 text-right flex flex-col items-end">
                    <div class="bg-[#1e3a8a] text-white text-xs px-3 py-1 rounded-sm font-bold mb-2 shadow-sm">চেম্বার :</div>
                    <h3 class="text-lg font-bold text-red-600 mb-1">পিওর সায়েন্টিফিক ডায়াগনস্টিক সার্ভিসেস্ লিঃ</h3>
                    <p class="text-xs text-[#1e3a8a] font-semibold leading-tight">ঢাকা মেডিকেল কলেজ ও হাসপাতাল ইউনিট-২<br>(নতুন বিল্ডিং) গেইটের বিপরীত পার্শ্বে,<br>লাজ ফার্মার সাথে, ঢাকা।</p>
                    <div class="mt-4 text-[10px] text-slate-600 flex flex-col items-end gap-1">
                        <div class="flex items-center gap-1"><span class="text-red-600">▶</span> Dr.Rayhan Uddin</div>
                        <div class="flex items-center gap-1"><span class="text-blue-600 font-bold">f</span> facebook.com/rayhan.uddin.33</div>
                    </div>
                </div>
            </div>

            <div class="bg-pink-100 mt-2 border-y border-pink-200 py-1.5 text-center shadow-inner">
                <p class="text-sm font-bold text-[#1e3a8a]">মেডিসিন, ডায়াবেটিস, পুরুষ বন্ধ্যত্ব, এলার্জী, চর্ম ও যৌন রোগে অভিজ্ঞ।</p>
            </div>

            <div class="flex justify-between items-center px-8 py-3 border-b-2 border-[#1e3a8a] text-sm text-[#1e3a8a] bg-slate-50">
                <div class="flex items-center gap-2 w-1/3">
                    <span class="font-semibold">Name:</span>
                    <span class="text-slate-900 border-b border-slate-300 flex-1 min-h-[20px] pb-1">{{ $prescription->appointment->patient_name ?? '' }}</span>
                </div>
                <div class="flex items-center gap-2 w-1/6">
                    <span class="font-semibold">Age:</span>
                    <span class="text-slate-900 border-b border-slate-300 flex-1 min-h-[20px] pb-1">{{ $prescription->appointment->patient_age ?? '' }}</span>
                </div>
                <div class="flex items-center gap-2 w-1/6">
                    <span class="font-semibold">Sex:</span>
                    <span class="text-slate-900 border-b border-slate-300 flex-1 min-h-[20px] pb-1">{{ $prescription->appointment->patient_sex ?? '' }}</span>
                </div>
                <div class="flex items-center gap-2 w-1/4">
                    <span class="font-semibold">Date:</span>
                    <span class="text-slate-900 border-b border-slate-300 flex-1 min-h-[20px] pb-1">{{ $prescription->appointment->appointment_date ? $prescription->appointment->appointment_date->format('d M Y') : '' }}</span>
                </div>
            </div>

            <div class="flex flex-1 items-stretch min-h-[700px]">
                
                <div class="w-[30%] bg-[#f4f8fc] border-r-2 border-[#1e3a8a] p-5 flex flex-col gap-6 shadow-inner">
                    <div class="flex flex-col">
                        <label class="font-bold text-[#1e3a8a] text-sm mb-1.5">C/C:</label>
                        <textarea name="chief_complaint" rows="3" class="w-full bg-white border border-slate-200 rounded-md p-2.5 text-sm text-slate-800 focus:ring-2 focus:ring-[#1e3a8a]/20 focus:border-[#1e3a8a] resize-none placeholder-slate-400 transition-all shadow-sm" placeholder="Type chief complaints...">{{ old('chief_complaint', $prescription->chief_complaint) }}</textarea>
                    </div>

                    <div class="flex flex-col">
                        <label class="font-bold text-[#1e3a8a] text-sm mb-1.5">O/E:</label>
                        <textarea name="on_examination" rows="3" class="w-full bg-white border border-slate-200 rounded-md p-2.5 text-sm text-slate-800 focus:ring-2 focus:ring-[#1e3a8a]/20 focus:border-[#1e3a8a] resize-none placeholder-slate-400 transition-all shadow-sm" placeholder="Type on examination...">{{ old('on_examination', $prescription->on_examination) }}</textarea>
                    </div>

                    <div class="flex flex-col gap-2 mt-2 text-xs font-medium text-slate-700 bg-white p-2.5 rounded-lg border border-slate-200 shadow-sm">
                        <div class="flex items-center gap-2">
                            <span class="w-5 text-[#1e3a8a] font-bold">BP:</span>
                            <input type="text" name="bp" value="{{ old('bp', $prescription->bp) }}" class="flex-1 bg-slate-50 border border-slate-200 rounded px-2 py-1 focus:bg-white focus:ring-1 focus:ring-[#1e3a8a]/30 focus:border-[#1e3a8a] transition-all text-xs" placeholder="   /   mmhg">
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="w-5 text-[#1e3a8a] font-bold">P:</span>
                            <input type="text" name="pulse" value="{{ old('pulse', $prescription->pulse) }}" class="flex-1 bg-slate-50 border border-slate-200 rounded px-2 py-1 focus:bg-white focus:ring-1 focus:ring-[#1e3a8a]/30 focus:border-[#1e3a8a] transition-all text-xs" placeholder="Beats/min">
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="w-5 text-[#1e3a8a] font-bold">T:</span>
                            <input type="text" name="temperature" value="{{ old('temperature', $prescription->temperature) }}" class="flex-1 bg-slate-50 border border-slate-200 rounded px-2 py-1 focus:bg-white focus:ring-1 focus:ring-[#1e3a8a]/30 focus:border-[#1e3a8a] transition-all text-xs" placeholder="°F">
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="w-5 text-[#1e3a8a] font-bold">H:</span>
                            <input type="text" name="height" value="{{ old('height', $prescription->height) }}" class="flex-1 bg-slate-50 border border-slate-200 rounded px-2 py-1 focus:bg-white focus:ring-1 focus:ring-[#1e3a8a]/30 focus:border-[#1e3a8a] transition-all text-xs" placeholder="cm">
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="w-5 text-[#1e3a8a] font-bold">L:</span>
                            <input type="text" name="weight" value="{{ old('weight', $prescription->weight) }}" class="flex-1 bg-slate-50 border border-slate-200 rounded px-2 py-1 focus:bg-white focus:ring-1 focus:ring-[#1e3a8a]/30 focus:border-[#1e3a8a] transition-all text-xs" placeholder="kg">
                        </div>
                    </div>

                    <div class="flex flex-col mt-2">
                        <label class="font-bold text-red-600 text-sm mb-1.5">Diagnosis <span class="text-red-500">*</span></label>
                        <textarea name="diagnosis" rows="3" required class="w-full bg-white border border-red-200 rounded-md p-2.5 text-sm text-slate-800 focus:ring-2 focus:ring-red-500/20 focus:border-red-500 resize-none placeholder-slate-400 transition-all shadow-sm" placeholder="Type primary diagnosis...">{{ old('diagnosis', $prescription->diagnosis) }}</textarea>
                    </div>

                    <div class="flex flex-col mt-2 flex-1">
                        <label class="font-bold text-[#1e3a8a] text-sm mb-1.5">Advice:</label>
                        <textarea name="advice" rows="4" class="w-full bg-white border border-slate-200 rounded-md p-2.5 text-sm text-slate-800 focus:ring-2 focus:ring-[#1e3a8a]/20 focus:border-[#1e3a8a] resize-none placeholder-slate-400 transition-all shadow-sm" placeholder="Type advice here...">{{ old('advice', $prescription->advice) }}</textarea>
                        
                        <div class="mt-5 bg-white p-3 rounded-lg border border-slate-200 shadow-sm">
                            <label class="font-bold text-[#1e3a8a] text-xs mb-2 block">Follow Up Date:</label>
                            <input type="date" name="follow_up_date" value="{{ old('follow_up_date', $prescription->follow_up_date ? \Carbon\Carbon::parse($prescription->follow_up_date)->format('Y-m-d') : '') }}" class="w-full bg-slate-50 border border-slate-200 rounded px-3 py-2 text-sm focus:bg-white focus:ring-2 focus:ring-[#1e3a8a]/20 focus:border-[#1e3a8a] transition-all cursor-pointer">
                        </div>
                    </div>
                </div>
                <div class="w-[70%] p-8 relative flex flex-col bg-white">
                    <div class="text-5xl font-serif italic font-bold text-[#1e3a8a] mb-8 opacity-90 drop-shadow-sm">Rx,</div>
                    
                    <div id="medicines-container" class="flex-1 space-y-5">
                        </div>
                    
                    <div class="mt-8 border-t border-dashed border-slate-300 pt-6 print:hidden">
                        <button type="button" onclick="addMedicine()" class="inline-flex items-center justify-center gap-2 rounded-lg bg-[#e6f0fa] border border-[#1e3a8a]/20 px-4 py-2.5 text-sm font-bold text-[#1e3a8a] hover:bg-[#1e3a8a] hover:text-white transition-all shadow-sm w-full sm:w-auto">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            Add New Medicine
                        </button>
                    </div>
                </div>
            </div>

            <div class="p-6 border-t border-slate-200 bg-slate-50 print:hidden">
                <h4 class="font-bold text-[#1e3a8a] text-lg mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Patient Reports & Investigations
                </h4>

                @if(isset($prescription->reports) && $prescription->reports->count() > 0)
                    <div class="mb-6">
                        <p class="text-sm font-semibold text-slate-700 mb-3 border-b border-slate-200 pb-1">Previously Uploaded Reports:</p>
                        <div class="flex flex-wrap gap-4">
                            @foreach($prescription->reports as $report)
                                <a href="{{ route('admin.reports.preview', $report) }}" target="_blank" class="block group relative w-24 h-24 border border-slate-300 rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-all bg-white">
                                    @if(in_array(pathinfo($report->path, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif']))
                                        <img src="{{ route('admin.reports.preview', $report) }}" alt="Report" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex flex-col items-center justify-center bg-gray-50 text-[#1e3a8a]">
                                            <svg class="w-8 h-8 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                                            <span class="text-[10px] font-bold uppercase">{{ pathinfo($report->path, PATHINFO_EXTENSION) }}</span>
                                        </div>
                                    @endif
                                    <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 flex items-center justify-center transition-opacity">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="bg-white p-4 border border-slate-200 rounded-lg">
                    <p class="text-sm font-semibold text-slate-700 mb-2">Attach New Reports:</p>
                    <input type="file" name="reports[]" id="reportInput" multiple class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-[#e6f0fa] file:text-[#1e3a8a] hover:file:bg-[#d0e3f5] transition-colors cursor-pointer" accept="image/*,.pdf,.doc,.docx">
                    
                    <div id="previewContainer" class="flex flex-wrap gap-4 mt-4 hidden">
                        </div>
                </div>
            </div>

            <div class="border-t-2 border-[#1e3a8a] bg-[#e6f0fa] py-2 text-center text-xs text-red-600 font-semibold shadow-inner" style="font-family: 'SolaimanLipi', serif;">
                দিন পর আসবেন, সাক্ষাতের সময় ব্যবস্থাপত্র সাথে আনবেন।<br>
                <span class="text-[10px] text-slate-600 font-normal">বিঃ দ্রঃ অনলাইনে কোনো রোগী দেখা হয়না ও ঔষধ পাঠানো হয়না। শুধুমাত্র সরাসরি চেম্বারে রোগী দেখা হয়।</span>
            </div>
        </div>

        <div class="max-w-[850px] mx-auto mt-6 mb-12 flex justify-end gap-4 print:hidden">
            <a href="{{ route('admin.appointments.show', $prescription->appointment_id) }}" class="px-5 py-2.5 bg-gray-200 text-gray-700 font-bold rounded-lg shadow hover:bg-gray-300 transition-colors">Cancel</a>
            <button type="submit" class="px-6 py-2.5 bg-[#1e3a8a] text-white font-bold rounded-lg shadow hover:bg-[#152c6b] transition-colors">
                Update Prescription
            </button>
        </div>
    </form>
</div>

<script>
    const searchRoute = '{{ route('admin.medicines.search') }}';
    const existingMedicines = @json(old('medicines', $existingMedicines));
    const selectedMedicineNames = @json($selectedMedicineNames ?? []);
    let medicineCount = 0;

    // --- Image Preview Logic ---
    function initializeReportPreview() {
        const reportInput = document.getElementById('reportInput');
        const previewContainer = document.getElementById('previewContainer');

        if (!reportInput || !previewContainer) {
            return;
        }

        reportInput.addEventListener('change', function(e) {
            previewContainer.innerHTML = ''; // Clear existing previews
            const files = e.target.files;

            if (files.length > 0) {
                previewContainer.classList.remove('hidden');
            } else {
                previewContainer.classList.add('hidden');
            }

            Array.from(files).forEach(file => {
                const previewWrapper = document.createElement('div');
                previewWrapper.className = 'w-20 h-20 border border-slate-300 rounded-lg overflow-hidden shadow-sm relative group bg-gray-50';

                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function(event) {
                        const img = document.createElement('img');
                        img.src = event.target.result;
                        img.className = 'w-full h-full object-cover';
                        previewWrapper.appendChild(img);
                    };
                    reader.readAsDataURL(file);
                } else {
                    // Non-image generic preview (e.g. PDF)
                    previewWrapper.innerHTML = `
                        <div class="w-full h-full flex flex-col items-center justify-center text-[#1e3a8a]">
                            <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                            <span class="text-[8px] font-bold uppercase truncate px-1 text-center w-full">${file.name.split('.').pop()}</span>
                        </div>
                    `;
                }
                
                // Add a simple "New" badge
                const badge = document.createElement('div');
                badge.className = 'absolute top-0 right-0 bg-green-500 text-white text-[8px] font-bold px-1 rounded-bl';
                badge.innerText = 'NEW';
                previewWrapper.appendChild(badge);

                previewContainer.appendChild(previewWrapper);
            });
        });
    }

    const minMedicineSearchLength = 2;
    const pendingMedicineSearch = new Map();

    function debounce(fn, delay = 250) {
        let timer;
        return function (...args) {
            clearTimeout(timer);
            timer = setTimeout(() => fn.apply(this, args), delay);
        };
    }

    async function fetchMedicineSuggestions(query, rowIndex) {
        const suggestions = document.querySelector(`#medicine-suggestions-${rowIndex}`);
        const hiddenInput = document.querySelector(`#medicine-id-${rowIndex}`);

        if (!query.trim() || query.trim().length < minMedicineSearchLength) {
            if (suggestions) {
                suggestions.innerHTML = '';
                suggestions.classList.add('hidden');
            }
            if (hiddenInput && !hiddenInput.value) {
                hiddenInput.value = '';
            }
            return;
        }

        if (pendingMedicineSearch.has(rowIndex)) {
            pendingMedicineSearch.get(rowIndex).abort();
        }

        const controller = new AbortController();
        pendingMedicineSearch.set(rowIndex, controller);

        try {
            const response = await fetch(`${searchRoute}?q=${encodeURIComponent(query)}`, {
                headers: { Accept: 'application/json' },
                signal: controller.signal,
            });
            const json = await response.json();

            if (pendingMedicineSearch.get(rowIndex) !== controller) {
                return;
            }

            renderMedicineSuggestions(json.medicines || [], rowIndex);
        } catch (error) {
            if (error.name === 'AbortError') {
                return;
            }

            console.error('Medicine search failed', error);
            if (suggestions) {
                suggestions.innerHTML = '<div class="px-3 py-2 text-sm text-slate-500">Unable to load results</div>';
                suggestions.classList.remove('hidden');
            }
        } finally {
            if (pendingMedicineSearch.get(rowIndex) === controller) {
                pendingMedicineSearch.delete(rowIndex);
            }
        }
    }

    function renderMedicineSuggestions(medicines, rowIndex) {
        const suggestions = document.querySelector(`#medicine-suggestions-${rowIndex}`);
        if (!suggestions) return;

        if (!medicines.length) {
            suggestions.innerHTML = '<div class="px-3 py-2 text-sm text-slate-500">No matching medicines</div>';
            suggestions.classList.remove('hidden');
            return;
        }

        const fragment = document.createDocumentFragment();
        medicines.forEach((m) => {
            const button = document.createElement('button');
            button.type = 'button';
            button.className = 'medicine-suggestion-item w-full text-left px-3 py-2 hover:bg-slate-100 focus:bg-slate-100 text-sm text-slate-700';
            button.dataset.row = rowIndex;
            button.dataset.id = m.id;

            let displayName = m.name
                ? `${m.name}${m.strength ? ' - ' + m.strength : ''}`
                : (m.generic_name || '');

            if (!m.name && m.manufacturer) {
                displayName += ` - ${m.manufacturer}`;
            }

            button.dataset.name = displayName;
            button.innerHTML = `<span class="font-semibold">${displayName}</span>`;
            fragment.appendChild(button);
        });

        suggestions.innerHTML = '';
        suggestions.appendChild(fragment);
        suggestions.classList.remove('hidden');
    }

    function selectMedicine(rowIndex, id, name) {
        const searchInput = document.querySelector(`#medicine-search-${rowIndex}`);
        const hiddenInput = document.querySelector(`#medicine-id-${rowIndex}`);
        const suggestions = document.querySelector(`#medicine-suggestions-${rowIndex}`);

        if (searchInput && hiddenInput) {
            searchInput.value = name;
            hiddenInput.value = id;
        }

        if (suggestions) {
            suggestions.innerHTML = '';
            suggestions.classList.add('hidden');
        }
    }

    function addMedicine(medicineData = null) {
        const container = document.getElementById('medicines-container');
        const index = medicineCount++;
        const medicineId = medicineData?.medicine_id || '';
        const medicineName = medicineData?.medicine_name || selectedMedicineNames[medicineId] || '';
        const morning = medicineData?.morning_dose || '';
        const afternoon = medicineData?.afternoon_dose || '';
        const night = medicineData?.night_dose || '';
        const duration = medicineData?.duration || '';
        const instruction = medicineData?.instruction || '';

        const rowHtml = `
            <div class="relative group flex gap-4 items-start bg-slate-50 border border-slate-200 p-4 rounded-lg shadow-sm" id="medicine-row-${index}">
                <div class="flex items-center justify-center bg-[#1e3a8a] text-white font-bold w-7 h-7 rounded-full text-xs shadow-sm mt-1 shrink-0">
                    ${index + 1}
                </div>
                <div class="flex-1 flex flex-wrap gap-4 items-center">
                    <div class="w-full min-w-[200px] relative">
                        <input type="hidden" id="medicine-id-${index}" name="medicines[${index}][medicine_id]" value="${medicineId}" required />
                        <input type="text" id="medicine-search-${index}" value="${medicineName}" placeholder="Search medicine by name or generic" class="medicine-search-input w-full bg-white border border-slate-300 rounded-md px-3 py-2 text-sm text-slate-900 focus:ring-2 focus:ring-[#1e3a8a]/20 focus:border-[#1e3a8a] shadow-inner transition-all" autocomplete="off" inputmode="search" />
                        <div id="medicine-suggestions-${index}" class="medicine-suggestions absolute left-0 right-0 mt-1 max-h-60 overflow-auto rounded-md border border-slate-200 bg-white shadow-lg z-10 hidden"></div>
                    </div>
                    <div class="flex items-center gap-1.5 text-sm font-medium text-slate-700 shrink-0">
                        <input type="text" name="medicines[${index}][morning_dose]" value="${morning}" class="w-10 text-center bg-white border border-slate-300 rounded-md py-1.5 px-1 focus:ring-2 focus:ring-[#1e3a8a]/20 focus:border-[#1e3a8a] shadow-inner transition-all" placeholder="0"> 
                        <span>+</span>
                        <input type="text" name="medicines[${index}][afternoon_dose]" value="${afternoon}" class="w-10 text-center bg-white border border-slate-300 rounded-md py-1.5 px-1 focus:ring-2 focus:ring-[#1e3a8a]/20 focus:border-[#1e3a8a] shadow-inner transition-all" placeholder="0"> 
                        <span>+</span>
                        <input type="text" name="medicines[${index}][night_dose]" value="${night}" class="w-10 text-center bg-white border border-slate-300 rounded-md py-1.5 px-1 focus:ring-2 focus:ring-[#1e3a8a]/20 focus:border-[#1e3a8a] shadow-inner transition-all" placeholder="0">
                    </div>
                    <div class="w-28 ml-auto">
                        <input type="text" name="medicines[${index}][duration]" value="${duration}" required class="w-full text-right bg-white border border-slate-300 rounded-md px-3 py-1.5 text-sm focus:ring-2 focus:ring-[#1e3a8a]/20 focus:border-[#1e3a8a] shadow-inner transition-all" placeholder="Duration">
                    </div>
                    <div class="w-full">
                        <input type="text" name="medicines[${index}][instruction]" value="${instruction}" class="w-full bg-white border border-slate-200 rounded-md px-3 py-1.5 text-xs text-slate-600 focus:ring-2 focus:ring-[#1e3a8a]/20 focus:border-[#1e3a8a] shadow-inner transition-all" placeholder="Instructions (e.g. After meal)">
                    </div>
                </div>
                <button type="button" class="absolute -top-2 -right-2 bg-red-100 text-red-600 rounded-full p-1 opacity-0 group-hover:opacity-100 hover:bg-red-500 hover:text-white transition-all shadow-sm border border-red-200 print:hidden" onclick="removeMedicine(${index})">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', rowHtml);
    }

    function removeMedicine(id) {
        const row = document.getElementById(`medicine-row-${id}`);
        if (row) {
            row.remove();
            reindexMedicineRows();
        }
    }

    function reindexMedicineRows() {
        const rows = Array.from(document.querySelectorAll('[id^="medicine-row-"]'));
        rows.forEach((row, idx) => {
            row.id = `medicine-row-${idx}`;
            const badge = row.querySelector('.w-7.h-7');
            if (badge) badge.textContent = idx + 1;
            const hiddenInput = row.querySelector('input[type="hidden"]');
            const searchInput = row.querySelector('.medicine-search-input');
            const suggestions = row.querySelector('.medicine-suggestions');
            const removeButton = row.querySelector('button[onclick^="removeMedicine("]');

            if (hiddenInput) hiddenInput.name = `medicines[${idx}][medicine_id]`;
            if (searchInput) searchInput.id = `medicine-search-${idx}`;
            if (suggestions) suggestions.id = `medicine-suggestions-${idx}`;
            if (removeButton) removeButton.setAttribute('onclick', `removeMedicine(${idx})`);

            const dosageInputs = row.querySelectorAll('input[name^="medicines["]');
            dosageInputs.forEach((input) => {
                const fieldName = input.name.replace(/medicines\[\d+\]/, `medicines[${idx}]`);
                input.name = fieldName;
            });
        });
        medicineCount = rows.length;
    }

    const debouncedSearch = debounce((query, index) => fetchMedicineSuggestions(query, index), 250);

    document.addEventListener('input', (event) => {
        if (!event.target.matches('.medicine-search-input')) return;
        const rowIndex = event.target.id.replace('medicine-search-', '');
        const hiddenInput = document.querySelector(`#medicine-id-${rowIndex}`);
        if (hiddenInput) hiddenInput.value = '';
        debouncedSearch(event.target.value, rowIndex);
    });

    document.addEventListener('click', (event) => {
        const target = event.target.closest('.medicine-suggestion-item');
        if (target) {
            selectMedicine(target.dataset.row, target.dataset.id, target.dataset.name);
            event.stopPropagation();
            return;
        }

        if (!event.target.closest('.medicine-suggestions') && !event.target.matches('.medicine-search-input')) {
            document.querySelectorAll('.medicine-suggestions').forEach((box) => box.classList.add('hidden'));
        }
    });

    document.addEventListener('DOMContentLoaded', () => {
        initializeReportPreview();

        if (existingMedicines && existingMedicines.length > 0) {
            existingMedicines.forEach(med => addMedicine(med));
        } else {
            addMedicine();
        }
    });
</script>
@endsection
