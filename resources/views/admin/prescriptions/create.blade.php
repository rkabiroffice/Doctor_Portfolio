@extends('layouts.admin')

@section('content')
<div class="max-w-5xl mx-auto mb-10">
    <div class="mb-4 flex justify-between items-center">
        <h1 class="text-2xl font-semibold text-slate-800">Create Prescription</h1>
        
        <a href="{{ route('admin.prescriptions.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-slate-200 rounded-lg shadow-sm text-sm font-medium text-slate-700 hover:bg-slate-50 hover:border-slate-300 hover:text-[#1e3a8a] transition-all">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Back to Prescriptions
        </a>
    </div>

    @if ($errors->any())
        <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg relative shadow-sm">
            <strong class="font-bold">Please fix the following errors:</strong>
            <ul class="mt-2 text-sm list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('admin.prescriptions.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="bg-white shadow-lg mx-auto w-full max-w-[850px] min-h-[1100px] border border-gray-200 flex flex-col relative text-slate-800 rounded-sm" style="font-family: Arial, sans-serif;">
            
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

            <div class="bg-pink-100 mt-12 border-y border-pink-200 py-1.5 text-center shadow-inner">
                <p class="text-sm font-bold text-[#1e3a8a]">মেডিসিন, ডায়াবেটিস, পুরুষ বন্ধ্যত্ব, এলার্জী, চর্ম ও যৌন রোগে অভিজ্ঞ।</p>
            </div>

            <div class="flex justify-between items-center px-8 py-3 border-b-2 border-[#1e3a8a] text-sm text-[#1e3a8a] relative bg-slate-50">
                
                <div class="absolute -top-24 print:hidden flex items-center gap-2 bg-white p-2 rounded-lg shadow border border-slate-200">
                    <label class="text-xs font-bold text-slate-700 text-red-500">Select Appointment:</label>
                    <select name="appointment_id" id="appointmentSelect" required class="text-sm border border-slate-300 rounded-md py-1.5 px-3 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-[#1e3a8a]/20 focus:border-[#1e3a8a] transition-all cursor-pointer shadow-inner">
                        <option value="">Choose...</option>
                        @foreach($appointments as $apt)
                            <option value="{{ $apt->id }}" {{ (old('appointment_id') == $apt->id || $appointmentId == $apt->id) ? 'selected' : '' }}>
                                {{ $apt->patient_name }} - {{ $apt->appointment_date->format('d M Y') }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex items-center gap-2 w-1/3">
                    <span class="font-semibold">Name:</span>
                    <span id="displayPatientName" class="text-slate-900 border-b border-slate-300 flex-1 min-h-[20px] pb-1">-</span>
                </div>
                <div class="flex items-center gap-2 w-1/6">
                    <span class="font-semibold">Age:</span>
                    <span id="displayPatientAge" class="text-slate-900 border-b border-slate-300 flex-1 min-h-[20px] pb-1">-</span>
                </div>
                <div class="flex items-center gap-2 w-1/6">
                    <span class="font-semibold">Sex:</span>
                    <span id="displayPatientSex" class="text-slate-900 border-b border-slate-300 flex-1 min-h-[20px] pb-1">-</span>
                </div>
                <div class="flex items-center gap-2 w-1/4">
                    <span class="font-semibold">Date:</span>
                    <span id="displayAppointmentDate" class="text-slate-900 border-b border-slate-300 flex-1 min-h-[20px] pb-1">-</span>
                </div>
            </div>

            <div class="flex flex-1 items-stretch">
                
                <div class="w-[30%] bg-[#f4f8fc] border-r-2 border-[#1e3a8a] p-5 flex flex-col gap-6 shadow-inner">
                    
                    <div class="flex flex-col">
                        <label class="font-bold text-[#1e3a8a] text-sm mb-1.5">C/C:</label>
                        <textarea name="chief_complaint" rows="3" class="w-full bg-white border border-slate-200 rounded-md p-2.5 text-sm text-slate-800 focus:ring-2 focus:ring-[#1e3a8a]/20 focus:border-[#1e3a8a] resize-none placeholder-slate-400 transition-all shadow-sm" placeholder="Type chief complaints...">{{ old('chief_complaint') }}</textarea>
                    </div>

                    <div class="flex flex-col">
                        <label class="font-bold text-[#1e3a8a] text-sm mb-1.5">O/E:</label>
                        <textarea name="on_examination" rows="3" class="w-full bg-white border border-slate-200 rounded-md p-2.5 text-sm text-slate-800 focus:ring-2 focus:ring-[#1e3a8a]/20 focus:border-[#1e3a8a] resize-none placeholder-slate-400 transition-all shadow-sm" placeholder="Type on examination...">{{ old('on_examination') }}</textarea>
                    </div>

                    <div class="flex flex-col gap-2 mt-2 text-xs font-medium text-slate-700 bg-white p-2.5 rounded-lg border border-slate-200 shadow-sm">
                        <div class="flex items-center gap-2">
                            <span class="w-5 text-[#1e3a8a] font-bold">BP:</span>
                            <input type="text" name="bp" value="{{ old('bp') }}" class="flex-1 bg-slate-50 border border-slate-200 rounded px-2 py-1 focus:bg-white focus:ring-1 focus:ring-[#1e3a8a]/30 focus:border-[#1e3a8a] transition-all text-xs" placeholder="   /   mmhg">
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="w-5 text-[#1e3a8a] font-bold">P:</span>
                            <input type="text" name="pulse" value="{{ old('pulse') }}" class="flex-1 bg-slate-50 border border-slate-200 rounded px-2 py-1 focus:bg-white focus:ring-1 focus:ring-[#1e3a8a]/30 focus:border-[#1e3a8a] transition-all text-xs" placeholder="Beats/min">
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="w-5 text-[#1e3a8a] font-bold">T:</span>
                            <input type="text" name="temperature" value="{{ old('temperature') }}" class="flex-1 bg-slate-50 border border-slate-200 rounded px-2 py-1 focus:bg-white focus:ring-1 focus:ring-[#1e3a8a]/30 focus:border-[#1e3a8a] transition-all text-xs" placeholder="°F">
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="w-5 text-[#1e3a8a] font-bold">H:</span>
                            <input type="text" name="height" value="{{ old('height') }}" class="flex-1 bg-slate-50 border border-slate-200 rounded px-2 py-1 focus:bg-white focus:ring-1 focus:ring-[#1e3a8a]/30 focus:border-[#1e3a8a] transition-all text-xs" placeholder="cm">
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="w-5 text-[#1e3a8a] font-bold">L:</span>
                            <input type="text" name="weight" value="{{ old('weight') }}" class="flex-1 bg-slate-50 border border-slate-200 rounded px-2 py-1 focus:bg-white focus:ring-1 focus:ring-[#1e3a8a]/30 focus:border-[#1e3a8a] transition-all text-xs" placeholder="kg">
                        </div>
                    </div>

                    <div class="flex flex-col mt-2">
                        <label class="font-bold text-red-600 text-sm mb-1.5">Diagnosis <span class="text-red-500">*</span></label>
                        <textarea name="diagnosis" rows="3" required class="w-full bg-white border border-red-200 rounded-md p-2.5 text-sm text-slate-800 focus:ring-2 focus:ring-red-500/20 focus:border-red-500 resize-none placeholder-slate-400 transition-all shadow-sm" placeholder="Type primary diagnosis...">{{ old('diagnosis') }}</textarea>
                    </div>

                    <div class="flex flex-col mt-2 flex-1">
                        <label class="font-bold text-[#1e3a8a] text-sm mb-1.5">Advice:</label>
                        <textarea name="advice" rows="4" class="w-full bg-white border border-slate-200 rounded-md p-2.5 text-sm text-slate-800 focus:ring-2 focus:ring-[#1e3a8a]/20 focus:border-[#1e3a8a] resize-none placeholder-slate-400 transition-all shadow-sm" placeholder="Type advice here...">{{ old('advice') }}</textarea>
                        
                        <div class="mt-5 bg-white p-3 rounded-lg border border-slate-200 shadow-sm">
                            <label class="font-bold text-[#1e3a8a] text-xs mb-2 block">Follow Up Date:</label>
                            <input type="date" name="follow_up_date" value="{{ old('follow_up_date') }}" class="w-full bg-slate-50 border border-slate-200 rounded px-3 py-2 text-sm focus:bg-white focus:ring-2 focus:ring-[#1e3a8a]/20 focus:border-[#1e3a8a] transition-all cursor-pointer">
                        </div>
                    </div>
                </div>

                <div class="w-[70%] p-8 relative flex flex-col bg-white">
                    <div class="text-5xl font-serif italic font-bold text-[#1e3a8a] mb-8 opacity-90 drop-shadow-sm">Rx,</div>
                    
                    <div id="medicines-container" class="flex-1 space-y-5"></div>
                    
                    <div class="mt-8 border-t border-dashed border-slate-300 pt-6 print:hidden">
                        <button type="button" onclick="addMedicine()" class="inline-flex items-center justify-center gap-2 rounded-lg bg-[#e6f0fa] border border-[#1e3a8a]/20 px-4 py-2.5 text-sm font-bold text-[#1e3a8a] hover:bg-[#1e3a8a] hover:text-white transition-all shadow-sm w-full sm:w-auto">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            Add New Medicine
                        </button>
                    </div>
                </div>
            </div>

            <div class="border-t-2 border-[#1e3a8a] bg-[#e6f0fa] py-2 text-center text-xs text-red-600 font-semibold shadow-inner" style="font-family: 'SolaimanLipi', serif;">
                দিন পর আসবেন, সাক্ষাতের সময় ব্যবস্থাপত্র সাথে আনবেন।<br>
                <span class="text-[10px] text-slate-600 font-normal">বিঃ দ্রঃ অনলাইনে কোনো রোগী দেখা হয়না ও ঔষধ পাঠানো হয়না। শুধুমাত্র সরাসরি চেম্বারে রোগী দেখা হয়।</span>
            </div>
        </div>

        <div class="max-w-[850px] mx-auto mt-8 bg-white rounded-xl shadow-sm border border-slate-200 p-6 print:hidden">
            <h3 class="text-sm font-bold text-slate-800 mb-4 border-b border-slate-100 pb-2">Attach Reports (Optional)</h3>
            
            <div class="flex items-center justify-center w-full mb-4">
                <label for="reportFiles" class="flex flex-col items-center justify-center w-full h-32 border-2 border-slate-300 border-dashed rounded-lg cursor-pointer bg-slate-50 hover:bg-slate-100 transition-colors">
                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                        <svg class="w-8 h-8 mb-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                        <p class="mb-2 text-sm text-slate-500"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                        <p class="text-xs text-slate-400">PDF, PNG, JPG, GIF, DOC or DOCX (MAX. 10MB)</p>
                    </div>
                    <input type="file" id="reportFiles" name="reports[]" multiple accept="image/*,.pdf,.doc,.docx" class="hidden">
                </label>
            </div>
            
            <div id="reportsPreview" class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-5 gap-4"></div>

            <div class="flex justify-end gap-3 mt-8 pt-4 border-t border-slate-100">
                <a href="{{ route('admin.prescriptions.index') }}" class="px-6 py-2.5 rounded-lg border border-slate-300 bg-white text-sm font-semibold text-slate-700 hover:bg-slate-50 transition-colors shadow-sm">Cancel</a>
                <button type="submit" class="px-6 py-2.5 rounded-lg bg-[#1e3a8a] text-white text-sm font-semibold hover:bg-blue-900 transition-colors shadow-sm inline-flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    Save Prescription
                </button>
            </div>
        </div>
    </form>
</div>

@php
    $appointmentData = $appointments->map(function ($a) {
        return [
           'id' => $a->id,
           'patient_name' => $a->patient_name,
           'patient_age' => $a->patient_age,
           'sex' => $a->sex,
           'date' => $a->appointment_date->format('d M Y'),
        ];
    })->toArray();
@endphp

<script>
    let medicineIndex = 0;
    const searchRoute = '{{ route('admin.medicines.search') }}';
    const selectedMedicineNames = @json($selectedMedicineNames ?? []);
    const initialMedicines = @json(old('medicines', []));
    const appointmentData = @json($appointmentData);
    const appointmentSelect = document.getElementById('appointmentSelect');
    const reportFiles = document.getElementById('reportFiles');
    const reportsPreview = document.getElementById('reportsPreview');
    
    function updatePatientDisplay() {
        const selected = appointmentSelect ? appointmentData.find(a => a.id == appointmentSelect.value) : null;
        
        document.getElementById('displayPatientName').textContent = selected ? selected.patient_name : '-';
        document.getElementById('displayPatientAge').textContent = selected ? (selected.patient_age || '-') : '-';
        document.getElementById('displayPatientSex').textContent = selected ? (selected.sex || '-') : '-';
        document.getElementById('displayAppointmentDate').textContent = selected ? selected.date : '-';
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

    function addMedicine(data = {}) {
        const container = document.getElementById('medicines-container');
        const index = medicineIndex++;
        const medicineId = data.medicine_id || '';
        const medicineName = data.medicine_name || selectedMedicineNames[medicineId] || '';
        const morningDose = data.morning_dose || '0';
        const afternoonDose = data.afternoon_dose || '0';
        const nightDose = data.night_dose || '0';
        const duration = data.duration || '';
        const instruction = data.instruction || '';

        const row = document.createElement('div');
        row.className = 'group relative flex gap-4 p-3 bg-slate-50 border border-slate-200 rounded-lg shadow-sm hover:border-[#1e3a8a]/30 transition-all';
        row.dataset.medicineIndex = index;
        row.innerHTML = `
            <div class="flex items-center justify-center bg-[#1e3a8a] text-white font-bold w-7 h-7 rounded-full text-xs shadow-sm mt-1 shrink-0">${index + 1}</div>
            <div class="flex-1 flex flex-wrap gap-4 items-center">
                <div class="w-full min-w-[200px] relative">
                    <input type="hidden" id="medicine-id-${index}" name="medicines[${index}][medicine_id]" value="${medicineId}" required />
                    <input type="text" id="medicine-search-${index}" value="${medicineName}" placeholder="Search medicine by name or generic" class="medicine-search-input w-full bg-white border border-slate-300 rounded-md px-3 py-2 text-sm text-slate-900 focus:ring-2 focus:ring-[#1e3a8a]/20 focus:border-[#1e3a8a] shadow-inner transition-all" autocomplete="off" inputmode="search" />
                    <div id="medicine-suggestions-${index}" class="medicine-suggestions absolute left-0 right-0 mt-1 max-h-60 overflow-auto rounded-md border border-slate-200 bg-white shadow-lg z-10 hidden"></div>
                </div>
                <div class="flex items-center gap-1.5 text-sm font-medium text-slate-700 shrink-0">
                    <input type="text" name="medicines[${index}][morning_dose]" value="${morningDose}" class="w-10 text-center bg-white border border-slate-300 rounded-md py-1.5 px-1 focus:ring-2 focus:ring-[#1e3a8a]/20 focus:border-[#1e3a8a] shadow-inner transition-all" placeholder="0">
                    <span>+</span>
                    <input type="text" name="medicines[${index}][afternoon_dose]" value="${afternoonDose}" class="w-10 text-center bg-white border border-slate-300 rounded-md py-1.5 px-1 focus:ring-2 focus:ring-[#1e3a8a]/20 focus:border-[#1e3a8a] shadow-inner transition-all" placeholder="0">
                    <span>+</span>
                    <input type="text" name="medicines[${index}][night_dose]" value="${nightDose}" class="w-10 text-center bg-white border border-slate-300 rounded-md py-1.5 px-1 focus:ring-2 focus:ring-[#1e3a8a]/20 focus:border-[#1e3a8a] shadow-inner transition-all" placeholder="0">
                </div>
                <div class="w-28 ml-auto">
                    <input type="text" name="medicines[${index}][duration]" value="${duration}" required class="w-full text-right bg-white border border-slate-300 rounded-md px-3 py-1.5 text-sm focus:ring-2 focus:ring-[#1e3a8a]/20 focus:border-[#1e3a8a] shadow-inner transition-all" placeholder="Duration">
                </div>
                <div class="w-full">
                    <input type="text" name="medicines[${index}][instruction]" value="${instruction}" class="w-full bg-white border border-slate-200 rounded-md px-3 py-1.5 text-xs text-slate-600 focus:ring-2 focus:ring-[#1e3a8a]/20 focus:border-[#1e3a8a] shadow-inner transition-all" placeholder="Instructions (e.g. After meal)">
                </div>
            </div>
            <button type="button" class="absolute -top-2 -right-2 bg-red-100 text-red-600 rounded-full p-1 opacity-0 group-hover:opacity-100 hover:bg-red-500 hover:text-white transition-all shadow-sm border border-red-200" onclick="removeMedicine(${index})">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        `;
        container.appendChild(row);
    }

    function removeMedicine(index) {
        const card = document.querySelector(`[data-medicine-index="${index}"]`);
        if (card) {
            card.remove();
            reindexMedicines();
        }
    }

    // Function to re-number the medicine dots after one is removed
    function reindexMedicines() {
        const container = document.getElementById('medicines-container');
        const rows = Array.from(container.querySelectorAll('[data-medicine-index]'));
        rows.forEach((row, idx) => {
            const numberDiv = row.querySelector('.w-7.h-7');
            if (numberDiv) {
                numberDiv.textContent = idx + 1;
            }
            row.dataset.medicineIndex = idx;
            const searchInput = row.querySelector('.medicine-search-input');
            const hiddenInput = row.querySelector('input[type="hidden"]');
            const suggestions = row.querySelector('.medicine-suggestions');
            const removeButton = row.querySelector('button[onclick^="removeMedicine("]');

            if (searchInput) searchInput.id = `medicine-search-${idx}`;
            if (hiddenInput) hiddenInput.id = `medicine-id-${idx}`;
            if (suggestions) suggestions.id = `medicine-suggestions-${idx}`;
            if (removeButton) removeButton.setAttribute('onclick', `removeMedicine(${idx})`);

            const fields = row.querySelectorAll('input[name^="medicines["]');
            fields.forEach((input) => {
                const suffix = input.name.substring(input.name.indexOf(']') + 1);
                input.name = `medicines[${idx}]${suffix}`;
            });
        });
        medicineIndex = rows.length;
    }

    function renderInitialMedicines() {
        if (Array.isArray(initialMedicines) && initialMedicines.length > 0) {
            initialMedicines.forEach((medicine) => addMedicine(medicine));
        } else {
            addMedicine();
        }
    }

    function formatBytes(bytes) {
        if (bytes === 0) return '0 KB';
        const sizes = ['Bytes', 'KB', 'MB'];
        const i = Math.floor(Math.log(bytes) / Math.log(1024));
        return `${parseFloat((bytes / Math.pow(1024, i)).toFixed(2))} ${sizes[i]}`;
    }

    function updateReportsPreview() {
        if (!reportFiles || !reportsPreview) {
            return;
        }

        reportsPreview.innerHTML = '';
        const files = Array.from(reportFiles.files || []);

        if (!files.length) {
            reportsPreview.innerHTML = '<div class="col-span-full text-center py-8 text-slate-500 border-2 border-dashed border-slate-200 rounded-lg">Select reports to see preview before upload.</div>';
            return;
        }

        files.forEach((file) => {
            const extension = file.name.split('.').pop().toLowerCase();
            const card = document.createElement('div');
            card.className = 'border border-slate-200 rounded-lg overflow-hidden shadow-sm bg-white';

            const preview = document.createElement('div');
            preview.className = 'w-full h-28 bg-slate-50 flex items-center justify-center overflow-hidden';

            if (file.type.startsWith('image/')) {
                const img = document.createElement('img');
                img.className = 'w-full h-full object-cover';
                const reader = new FileReader();
                reader.onload = (event) => {
                    img.src = event.target.result;
                };
                reader.readAsDataURL(file);
                preview.appendChild(img);
            } else {
                const iconWrapper = document.createElement('div');
                iconWrapper.className = 'flex flex-col items-center justify-center gap-2 text-slate-500';
                iconWrapper.innerHTML = `
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414A1 1 0 0018.586 9H19v11a2 2 0 01-2 2z"></path></svg>
                    <span class="text-xs uppercase font-semibold">${extension}</span>
                `;
                preview.appendChild(iconWrapper);
            }

            const info = document.createElement('div');
            info.className = 'p-3';
            info.innerHTML = `
                <p class="text-sm font-semibold text-slate-900 truncate">${file.name}</p>
                <p class="text-xs text-slate-500 mt-1">${formatBytes(file.size)}</p>
            `;

            card.appendChild(preview);
            card.appendChild(info);
            reportsPreview.appendChild(card);
        });
    }

    const debouncedSearch = debounce((query, index) => fetchMedicineSuggestions(query, index), 250);

    document.addEventListener('DOMContentLoaded', () => {
        const medicinesContainer = document.getElementById('medicines-container');
        const appointmentSelect = document.getElementById('appointmentSelect');
        const reportFiles = document.getElementById('reportFiles');
        const reportsPreview = document.getElementById('reportsPreview');

        if (medicinesContainer) {
            medicinesContainer.addEventListener('input', (event) => {
                if (!event.target.matches('.medicine-search-input')) {
                    return;
                }

                const rowIndex = event.target.id.replace('medicine-search-', '');
                const query = event.target.value;
                const hiddenInput = document.querySelector(`#medicine-id-${rowIndex}`);
                if (hiddenInput) {
                    hiddenInput.value = '';
                }
                debouncedSearch(query, rowIndex);
            });
        }

        document.addEventListener('click', (event) => {
            const target = event.target.closest('.medicine-suggestion-item');
            if (target) {
                selectMedicine(target.dataset.row, target.dataset.id, target.dataset.name);
                return;
            }

            if (!event.target.closest('.medicine-suggestions') && !event.target.matches('.medicine-search-input')) {
                document.querySelectorAll('.medicine-suggestions').forEach((list) => list.classList.add('hidden'));
            }
        });

        if (appointmentSelect) {
            appointmentSelect.addEventListener('change', updatePatientDisplay);
            updatePatientDisplay();
        }

        if (reportFiles && reportsPreview) {
            reportFiles.addEventListener('change', updateReportsPreview);
        }

        renderInitialMedicines();
    });
</script>
@endsection
