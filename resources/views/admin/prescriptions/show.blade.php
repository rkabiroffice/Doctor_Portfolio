@extends('layouts.admin')

@section('content')
<div class="container mx-auto py-8">
    
    <!-- Action Buttons (Top) -->
    <div class="max-w-[850px] mx-auto mb-4 flex justify-between items-center print:hidden">
        <a href="{{ route('admin.appointments.show', $prescription->appointment_id) }}" class="px-4 py-2 bg-slate-200 text-slate-700 font-bold rounded-lg shadow hover:bg-slate-300 transition-colors inline-flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Back
        </a>
        <div class="flex gap-3">
            <a href="{{ route('admin.prescriptions.edit', $prescription->id) }}" class="px-4 py-2 bg-blue-100 text-[#1e3a8a] border border-blue-200 font-bold rounded-lg shadow hover:bg-blue-200 transition-colors inline-flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                Edit
            </a>
            <a href="{{ route('admin.prescriptions.pdf', $prescription->id) }}" class="px-4 py-2 bg-blue-100 text-[#1e3a8a] border border-blue-200 font-bold rounded-lg shadow hover:bg-blue-200 transition-colors inline-flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                Download PDF
            </a>
            <button onclick="window.print()" class="px-4 py-2 bg-[#1e3a8a] text-white font-bold rounded-lg shadow hover:bg-[#152c6b] transition-colors inline-flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                Print
            </button>
            
        </div>
    </div>

    <!-- Printable Prescription Card -->
    <div id="printable-prescription" class="bg-white shadow-lg mx-auto w-full max-w-[850px] border border-gray-200 flex flex-col relative text-slate-800 rounded-sm print:shadow-none print:border-none" style="font-family: Arial, sans-serif;">
        
        <!-- Header Section -->
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
                <div class="border-2 border-[#1e3a8a] rounded-full px-3 py-1 mb-1 shadow-sm print:shadow-none">
                    <p class="text-xs font-bold text-[#1e3a8a]">সিরিয়ালের জন্য :</p>
                </div>
                <p class="text-sm font-bold text-red-600 leading-tight">01647-386185<br>01727-375664</p>
                <p class="text-[10px] text-slate-600">(সকাল ১১ টা - দুপুর ৩ টা পর্যন্ত)</p>
                
                <div class="border border-dashed border-red-500 bg-red-50/30 rounded-lg p-1 mt-2 w-full print:bg-transparent">
                    <p class="text-xs font-bold text-red-600 border-b border-red-200 pb-1 mb-1">রোগী দেখার সময় :</p>
                    <p class="text-[10px] text-slate-600 leading-tight">প্রতি বৃহস্পতি, শুক্র ও শনিবার<br>(দুপুর ২টা থেকে রাত ১০টা পর্যন্ত)</p>
                </div>
                <p class="text-[9px] mt-2 text-slate-500">চেম্বারে আসার পূর্বে ফোনে যোগাযোগ করে আসবেন।</p>
            </div>

            <div class="w-2/5 text-right flex flex-col items-end">
                <div class="bg-[#1e3a8a] text-white text-xs px-3 py-1 rounded-sm font-bold mb-2 shadow-sm print:shadow-none print:border print:border-[#1e3a8a] print:text-[#1e3a8a]">চেম্বার :</div>
                <h3 class="text-lg font-bold text-red-600 mb-1">পিওর সায়েন্টিফিক ডায়াগনস্টিক সার্ভিসেস্ লিঃ</h3>
                <p class="text-xs text-[#1e3a8a] font-semibold leading-tight">ঢাকা মেডিকেল কলেজ ও হাসপাতাল ইউনিট-২<br>(নতুন বিল্ডিং) গেইটের বিপরীত পার্শ্বে,<br>লাজ ফার্মার সাথে, ঢাকা।</p>
                <div class="mt-4 text-[10px] text-slate-600 flex flex-col items-end gap-1">
                    <div class="flex items-center gap-1"><span class="text-red-600">▶</span> Dr.Rayhan Uddin</div>
                    <div class="flex items-center gap-1"><span class="text-blue-600 font-bold">f</span> facebook.com/rayhan.uddin.33</div>
                </div>
            </div>
        </div>

        <div class="bg-pink-100 mt-2 border-y border-pink-200 py-1.5 text-center shadow-inner print:shadow-none print:bg-white">
            <p class="text-sm font-bold text-[#1e3a8a]">মেডিসিন, ডায়াবেটিস, পুরুষ বন্ধ্যত্ব, এলার্জী, চর্ম ও যৌন রোগে অভিজ্ঞ।</p>
        </div>

        <!-- Patient Info Bar -->
        <div class="flex justify-between items-center px-8 py-3 border-b-2 border-[#1e3a8a] text-sm text-[#1e3a8a] bg-slate-50 print:bg-white">
            <div class="flex items-center gap-2 w-1/3">
                <span class="font-semibold">Name:</span>
                <span class="text-slate-900 font-medium">{{ $prescription->appointment->patient_name ?? 'N/A' }}</span>
            </div>
            <div class="flex items-center gap-2 w-1/5">
                <span class="font-semibold">Patient ID:</span>
                <span class="text-slate-900 font-medium">{{ $prescription->appointment->patient->uid ?? 'N/A' }}</span>
            </div>
            <div class="flex items-center gap-2 w-1/5">
                <span class="font-semibold">Age:</span>
                <span class="text-slate-900 font-medium">{{ $prescription->appointment->patient_age ?? 'N/A' }}</span>
            </div>
            <div class="flex items-center gap-2 w-1/5">
                <span class="font-semibold">Sex:</span>
                <span class="text-slate-900 font-medium">{{ $prescription->appointment->patient_sex ?? 'N/A' }}</span>
            </div>
            <div class="flex items-center gap-2 w-1/5">
                <span class="font-semibold">Date:</span>
                <span class="text-slate-900 font-medium">{{ $prescription->appointment->appointment_date ? $prescription->appointment->appointment_date->format('d M Y') : 'N/A' }}</span>
            </div>
        </div>

        <div class="flex flex-1 items-stretch min-h-[700px]">
            
            <!-- Left Column: Vitals, Complaints, Diagnosis -->
            <div class="w-[30%] bg-[#f4f8fc] print:bg-white print:border-r print:border-[#1e3a8a] border-r-2 border-[#1e3a8a] p-5 flex flex-col gap-6 shadow-inner print:shadow-none">
                
                <div class="flex flex-col">
                    <label class="font-bold text-[#1e3a8a] text-sm mb-1.5">C/C:</label>
                    <div class="w-full bg-white border border-slate-200 rounded-md p-2.5 text-sm text-slate-800 shadow-sm print:shadow-none min-h-[60px] whitespace-pre-wrap">{{ $prescription->chief_complaint ?: 'None recorded' }}</div>
                </div>

                <div class="flex flex-col">
                    <label class="font-bold text-[#1e3a8a] text-sm mb-1.5">O/E:</label>
                    <div class="w-full bg-white border border-slate-200 rounded-md p-2.5 text-sm text-slate-800 shadow-sm print:shadow-none min-h-[60px] whitespace-pre-wrap">{{ $prescription->on_examination ?: 'None recorded' }}</div>
                </div>

                <!-- Vitals Block -->
                <div class="flex flex-col gap-2 mt-2 text-xs font-medium text-slate-700 bg-white p-3 rounded-lg border border-slate-200 shadow-sm print:shadow-none">
                    <div class="flex items-center gap-2">
                        <span class="w-5 text-[#1e3a8a] font-bold">BP:</span>
                        <span class="flex-1 text-slate-900">{{ $prescription->bp ?: '-- / --' }} <span class="text-slate-400">mmhg</span></span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-5 text-[#1e3a8a] font-bold">P:</span>
                        <span class="flex-1 text-slate-900">{{ $prescription->pulse ?: '--' }} <span class="text-slate-400">Beats/min</span></span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-5 text-[#1e3a8a] font-bold">T:</span>
                        <span class="flex-1 text-slate-900">{{ $prescription->temperature ?: '--' }} <span class="text-slate-400">°F</span></span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-5 text-[#1e3a8a] font-bold">H:</span>
                        <span class="flex-1 text-slate-900">{{ $prescription->height ?: '--' }} <span class="text-slate-400">cm</span></span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-5 text-[#1e3a8a] font-bold">L:</span>
                        <span class="flex-1 text-slate-900">{{ $prescription->weight ?: '--' }} <span class="text-slate-400">kg</span></span>
                    </div>
                </div>

                <div class="flex flex-col mt-2">
                    <label class="font-bold text-red-600 text-sm mb-1.5">Diagnosis:</label>
                    <div class="w-full bg-white border border-red-200 rounded-md p-2.5 text-sm text-slate-800 shadow-sm print:shadow-none min-h-[60px] whitespace-pre-wrap">{{ $prescription->diagnosis ?: 'Pending' }}</div>
                </div>

                <div class="flex flex-col mt-2 flex-1">
                    <label class="font-bold text-[#1e3a8a] text-sm mb-1.5">Advice:</label>
                    <div class="w-full bg-white border border-slate-200 rounded-md p-2.5 text-sm text-slate-800 shadow-sm print:shadow-none flex-1 whitespace-pre-wrap">{{ $prescription->advice ?: 'No specific advice given.' }}</div>
                    
                    @if($prescription->follow_up_date)
                    <div class="mt-5 bg-white p-3 rounded-lg border border-slate-200 shadow-sm print:shadow-none print:border-[#1e3a8a]">
                        <label class="font-bold text-[#1e3a8a] text-xs mb-1 block">Follow Up Date:</label>
                        <p class="text-sm font-bold text-red-600">{{ \Carbon\Carbon::parse($prescription->follow_up_date)->format('d F Y (l)') }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Right Column: Rx and Medicines -->
            <div class="w-[70%] p-8 relative flex flex-col bg-white">
                <div class="text-5xl font-serif italic font-bold text-[#1e3a8a] mb-8 opacity-90 drop-shadow-sm print:drop-shadow-none">Rx,</div>
                
                <div class="flex-1 space-y-5">
                    @forelse($prescription->prescriptionMedicines as $index => $medicineData)
                        <div class="relative flex gap-4 items-start bg-slate-50 print:bg-white border border-slate-200 print:border-b print:border-x-0 print:border-t-0 print:rounded-none p-4 print:px-0 print:py-3 rounded-lg shadow-sm print:shadow-none">
                            
                            <!-- Serial Number Badge -->
                            <div class="flex items-center justify-center bg-[#1e3a8a] text-white font-bold w-7 h-7 rounded-full text-xs shadow-sm mt-1 shrink-0 print:border print:border-[#1e3a8a] print:bg-white print:text-[#1e3a8a]">
                                {{ $index + 1 }}
                            </div>
                            
                            <div class="flex-1 flex flex-wrap gap-x-4 gap-y-2 items-center">
                                <!-- Medicine Name -->
                                <div class="flex-1 min-w-[200px]">
                                    <h4 class="text-base font-bold text-slate-900">{{ $medicineData->medicine->name ?? 'Unknown Medicine' }}</h4>
                                </div>

                                <!-- Dosing Pattern -->
                                <div class="flex items-center gap-2 text-sm font-bold text-[#1e3a8a] shrink-0 bg-white border border-slate-200 rounded px-3 py-1 print:border-none print:bg-transparent print:p-0">
                                    <span>{{ $medicineData->morning_dose ?: '0' }}</span>
                                    <span class="text-slate-400 font-normal">+</span>
                                    <span>{{ $medicineData->afternoon_dose ?: '0' }}</span>
                                    <span class="text-slate-400 font-normal">+</span>
                                    <span>{{ $medicineData->night_dose ?: '0' }}</span>
                                </div>

                                <!-- Duration -->
                                <div class="w-28 text-right">
                                    <span class="text-sm font-semibold text-slate-700 bg-slate-200/50 px-2 py-1 rounded print:bg-transparent print:p-0">{{ $medicineData->duration }}</span>
                                </div>

                                <!-- Additional Instructions -->
                                @if($medicineData->instruction)
                                <div class="w-full mt-1">
                                    <p class="text-xs text-slate-600 bg-white border border-slate-100 rounded px-3 py-1.5 print:bg-transparent print:border-none print:p-0 print:italic">
                                        <span class="font-semibold text-slate-500 mr-1">Inst:</span> {{ $medicineData->instruction }}
                                    </p>
                                </div>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-10 text-slate-400 italic">
                            No medicines prescribed.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Patient Reports & Investigations (Hidden on Print) -->
        @if(isset($prescription->reports) && $prescription->reports->count() > 0)
        <div class="p-6 border-t border-slate-200 bg-slate-50 print:hidden">
            <h4 class="font-bold text-[#1e3a8a] text-lg mb-4 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                Patient Reports & Investigations
            </h4>

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

        <!-- Footer Note -->
        <div class="border-t-2 border-[#1e3a8a] bg-[#e6f0fa] py-2 text-center text-xs text-red-600 font-semibold shadow-inner print:shadow-none print:bg-white print:border-slate-300" style="font-family: 'SolaimanLipi', serif;">
            দিন পর আসবেন, সাক্ষাতের সময় ব্যবস্থাপত্র সাথে আনবেন।<br>
            <span class="text-[10px] text-slate-600 font-normal">বিঃ দ্রঃ অনলাইনে কোনো রোগী দেখা হয়না ও ঔষধ পাঠানো হয়না। শুধুমাত্র সরাসরি চেম্বারে রোগী দেখা হয়।</span>
        </div>
    </div>
</div>

<style>
    /* 1. Force the printer to use A4 paper size */
    @page {
        size: A4 portrait;
        margin: 0; /* Removes default browser headers/footers and margins */
    }

    @media print {
        body * {
            visibility: hidden; /* Hides everything */
        }
        
        #printable-prescription, #printable-prescription * {
            visibility: visible; /* Shows only the prescription */
        }
        
        /* 2. Position and lock the layout to exact A4 dimensions */
        #printable-prescription {
            position: absolute;
            left: 0;
            top: 0;
            width: 210mm;  /* Exact A4 width */
            min-height: 297mm; /* Exact A4 height */
            margin: 0;
            box-sizing: border-box;
            background-color: white;
        }
    }
</style>
@endsection
