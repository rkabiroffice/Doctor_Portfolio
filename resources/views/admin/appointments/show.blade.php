@extends('layouts.admin')

@section('content')
<div class="max-w-5xl">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-8 mb-6">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-2xl font-bold text-slate-900">Appointment Details</h2>
                <p class="text-sm text-slate-500 mt-1">Patient information and consultation details</p>
            </div>
            <span class="{{ $appointment->status === 'confirmed' || $appointment->status === 'completed' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : ($appointment->status === 'pending' ? 'bg-amber-50 text-amber-700 border border-amber-200' : 'bg-red-50 text-red-700 border border-red-200') }} px-4 py-2 rounded-full text-sm font-medium">{{ ucfirst($appointment->status) }}</span>
        </div>

        <div class="grid md:grid-cols-2 gap-6 mb-6">
            <div>
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Patient Name</p>
                <p class="text-base font-semibold text-slate-900">{{ $appointment->patient_name }}</p>
            </div>
            <div>
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Patient ID</p>
                <p class="text-base text-slate-700">{{ $appointment->patient?->id ? '#' . $appointment->patient->id : 'Unlinked' }}</p>
            </div>
            <div>
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Phone</p>
                <p class="text-base text-slate-700">{{ $appointment->phone }}</p>
            </div>
            <div>
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Email</p>
                <p class="text-base text-slate-700">{{ $appointment->email ?? 'Not provided' }}</p>
            </div>
            <div>
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Clinic</p>
                <p class="text-base text-slate-700">{{ $appointment->clinic->name ?? ' ' }}</p>
            </div>
            <div>
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Appointment Date</p>
                <p class="text-base text-slate-700">{{ $appointment->appointment_date->format('d M Y') }}</p>
            </div>
            <div>
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Appointment Time</p>
                <p class="text-base text-slate-700">{{ $appointment->appointment_time }}</p>
            </div>
        </div>

        <div class="mb-6">
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Reason for Visit</p>
            <p class="text-sm text-slate-700 leading-7 bg-slate-50 rounded-lg p-4 border border-slate-200">{{ $appointment->reason }}</p>
        </div>

        <div class="flex flex-col gap-3 md:flex-row md:items-start mb-2">
            <form action="{{ route('admin.appointments.update', $appointment) }}" method="POST" class="inline">
                @csrf
                @method('PUT')
                <select name="status" onchange="this.form.submit()" class="rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-all duration-150">
                    <option value="pending" {{ $appointment->status === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="confirmed" {{ $appointment->status === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                    <option value="completed" {{ $appointment->status === 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="cancelled" {{ $appointment->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </form>
            @if($appointment->status === 'confirmed' || $appointment->status === 'completed')
                <div class="space-y-4 w-full">
                    <div class="flex items-center justify-between gap-3">
                        <div>
                            <p class="text-sm font-semibold text-slate-700">Upload Appointment Reports</p>
                            <p class="text-xs text-slate-500">Select one or more files to preview before saving.</p>
                        </div>
                    </div>
                    <div class="space-y-3 w-full">
                        <form action="{{ route('admin.reports.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                            @csrf
                            <input type="hidden" name="appointment_id" value="{{ $appointment->id }}">

                            <div class="grid gap-4">
                                <label class="block">
                                    <span class="text-sm font-semibold text-slate-700">Select reports</span>
                                    <input type="file" id="appointmentReportFiles" name="reports[]" multiple accept="image/*,.pdf,.doc,.docx" class="mt-2 block w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500" />
                                </label>
                                <button type="submit" class="inline-flex items-center justify-center bg-brand-600 hover:bg-brand-700 text-white text-sm font-medium px-5 py-2 rounded-lg transition-all duration-150">
                                    Upload Reports
                                </button>
                            </div>

                            <div class="flex items-center justify-between gap-3">
                                <p class="text-sm font-semibold text-slate-700">Selected Report Previews</p>
                                <p class="text-xs text-slate-500">Preview is only for selected files before upload.</p>
                            </div>

                            <div id="appointmentReportsPreview" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4 min-h-[10rem]">
                                <div id="appointmentReportsEmpty" class="col-span-full text-center py-8 text-slate-500 text-sm border-2 border-dashed border-slate-200 rounded-lg">
                                    Select reports to see preview before upload.
                                </div>
                            </div>
                        </form>

                            @php
                                $combinedReports = [];
                                foreach ($appointment->reports as $report) {
                                    $combinedReports[] = ['report' => $report, 'source' => 'appointment'];
                                }
                                if ($appointment->prescription) {
                                    foreach ($appointment->prescription->reports as $report) {
                                        $combinedReports[] = ['report' => $report, 'source' => 'prescription'];
                                    }
                                }
                            @endphp

                    @if(count($combinedReports) > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($combinedReports as $item)
                                @php $report = $item['report']; $source = $item['source']; @endphp
                                <div class="relative bg-white rounded-lg border border-slate-200 overflow-hidden hover:shadow-md transition-all duration-150">
                                    @php $extension = strtolower(pathinfo($report->path, PATHINFO_EXTENSION)); @endphp
                                    @if(in_array($extension, ['jpg','jpeg','png','gif']) && $report->disk === 'public')
                                        <img src="{{ route('admin.reports.preview', $report) }}" alt="Report" class="w-full h-32 object-cover">
                                    @elseif($extension === 'pdf')
                                        <div class="w-full h-32 bg-red-50 flex items-center justify-center">
                                            <svg class="w-12 h-12 text-red-400" fill="currentColor" viewBox="0 0 20 20"><path d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm0 2h12v10H4V5z"></path></svg>
                                        </div>
                                    @else
                                        <div class="w-full h-32 bg-slate-100 flex items-center justify-center text-slate-500">
                                            <span class="text-sm">File</span>
                                        </div>
                                    @endif
                                    <div class="p-3 bg-slate-50 border-t border-slate-200">
                                        <div class="flex items-center justify-between gap-3 mb-2">
                                            <p class="text-sm font-semibold text-slate-900 truncate">{{ $report->name }}</p>
                                            <span class="text-xs text-slate-500 uppercase tracking-wide">{{ $source === 'appointment' ? 'Appointment' : 'Prescription' }}</span>
                                        </div>
                                        @if($report->size)
                                            <p class="text-xs text-slate-500">{{ round($report->size / 1024, 2) }} KB</p>
                                        @endif
                                        <div class="mt-2 flex flex-wrap gap-2">
                                                    <a href="{{ route('admin.reports.download', $report) }}" class="text-xs bg-blue-600 hover:bg-blue-700 text-white px-2 py-1 rounded">Download</a>
                                                @if($source === 'appointment')
                                                    <form action="{{ route('admin.reports.destroy', $report) }}" method="POST" class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" onclick="return confirm('Remove this report?')" class="text-xs bg-red-50 hover:bg-red-100 text-red-700 px-2 py-1 rounded">Remove</button>
                                                    </form>
                                                @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            @endif
            @if(!$appointment->prescription)
                <a href="{{ route('admin.prescriptions.create', ['appointment_id' => $appointment->id]) }}" class="bg-brand-600 hover:bg-brand-700 text-white font-medium px-5 py-2 rounded-lg shadow-sm transition-all duration-150 inline-flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Write Prescription
                </a>
            @else
                <a href="{{ route('admin.prescriptions.show', $appointment->prescription) }}" class="bg-brand-600 hover:bg-brand-700 text-white font-medium px-5 py-2 rounded-lg shadow-sm transition-all duration-150 inline-flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    View Prescription
                </a>
            @endif
            <a href="{{ route('admin.appointments.index') }}" class="bg-slate-100 hover:bg-slate-200 text-slate-700 font-medium px-5 py-2 rounded-lg transition-all duration-150">Back to List</a>
        </div>
    </div>

    @if($appointment->prescription)
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
                <span class="text-slate-900 font-medium">{{ $appointment->prescription->appointment->patient_name ?? ' ' }}</span>
            </div>
            <div class="flex items-center gap-2 w-1/6">
                <span class="font-semibold">Age:</span>
                <span class="text-slate-900 font-medium">{{ $appointment->prescription->appointment->patient_age ?? ' ' }}</span>
            </div>
            <div class="flex items-center gap-2 w-1/6">
                <span class="font-semibold">Sex:</span>
                <span class="text-slate-900 font-medium">{{ $appointment->prescription->appointment->patient_sex ?? ' ' }}</span>
            </div>
            <div class="flex items-center gap-2 w-1/4">
                <span class="font-semibold">Date:</span>
                <span class="text-slate-900 font-medium">{{ $appointment->prescription->appointment->appointment_date ? $appointment->prescription->appointment->appointment_date->format('d M Y') : ' ' }}</span>
            </div>
        </div>

        <div class="flex flex-1 items-stretch min-h-[700px]">
            
            <!-- Left Column: Vitals, Complaints, Diagnosis -->
            <div class="w-[30%] bg-[#f4f8fc] print:bg-white print:border-r print:border-[#1e3a8a] border-r-2 border-[#1e3a8a] p-5 flex flex-col gap-6 shadow-inner print:shadow-none">
                
                <div class="flex flex-col">
                    <label class="font-bold text-[#1e3a8a] text-sm mb-1.5">C/C:</label>
                    <div class="w-full bg-white border border-slate-200 rounded-md p-2.5 text-sm text-slate-800 shadow-sm print:shadow-none min-h-[60px] whitespace-pre-wrap">{{ $appointment->prescription->chief_complaint ?: 'None recorded' }}</div>
                </div>

                <div class="flex flex-col">
                    <label class="font-bold text-[#1e3a8a] text-sm mb-1.5">O/E:</label>
                    <div class="w-full bg-white border border-slate-200 rounded-md p-2.5 text-sm text-slate-800 shadow-sm print:shadow-none min-h-[60px] whitespace-pre-wrap">{{ $appointment->prescription->on_examination ?: 'None recorded' }}</div>
                </div>

                <!-- Vitals Block -->
                <div class="flex flex-col gap-2 mt-2 text-xs font-medium text-slate-700 bg-white p-3 rounded-lg border border-slate-200 shadow-sm print:shadow-none">
                    <div class="flex items-center gap-2">
                        <span class="w-5 text-[#1e3a8a] font-bold">BP:</span>
                        <span class="flex-1 text-slate-900">{{ $appointment->prescription->bp ?: '-- / --' }} <span class="text-slate-400">mmhg</span></span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-5 text-[#1e3a8a] font-bold">P:</span>
                        <span class="flex-1 text-slate-900">{{ $appointment->prescription->pulse ?: '--' }} <span class="text-slate-400">Beats/min</span></span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-5 text-[#1e3a8a] font-bold">T:</span>
                        <span class="flex-1 text-slate-900">{{ $appointment->prescription->temperature ?: '--' }} <span class="text-slate-400">°F</span></span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-5 text-[#1e3a8a] font-bold">H:</span>
                        <span class="flex-1 text-slate-900">{{ $appointment->prescription->height ?: '--' }} <span class="text-slate-400">cm</span></span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-5 text-[#1e3a8a] font-bold">L:</span>
                        <span class="flex-1 text-slate-900">{{ $appointment->prescription->weight ?: '--' }} <span class="text-slate-400">kg</span></span>
                    </div>
                </div>

                <div class="flex flex-col mt-2">
                    <label class="font-bold text-red-600 text-sm mb-1.5">Diagnosis:</label>
                    <div class="w-full bg-white border border-red-200 rounded-md p-2.5 text-sm text-slate-800 shadow-sm print:shadow-none min-h-[60px] whitespace-pre-wrap">{{ $appointment->prescription->diagnosis ?: 'Pending' }}</div>
                </div>

                <div class="flex flex-col mt-2 flex-1">
                    <label class="font-bold text-[#1e3a8a] text-sm mb-1.5">Advice:</label>
                    <div class="w-full bg-white border border-slate-200 rounded-md p-2.5 text-sm text-slate-800 shadow-sm print:shadow-none flex-1 whitespace-pre-wrap">{{ $appointment->prescription->advice ?: 'No specific advice given.' }}</div>
                    
                    @if($appointment->prescription->follow_up_date)
                    <div class="mt-5 bg-white p-3 rounded-lg border border-slate-200 shadow-sm print:shadow-none print:border-[#1e3a8a]">
                        <label class="font-bold text-[#1e3a8a] text-xs mb-1 block">Follow Up Date:</label>
                        <p class="text-sm font-bold text-red-600">{{ \Carbon\Carbon::parse($appointment->prescription->follow_up_date)->format('d F Y (l)') }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Right Column: Rx and Medicines -->
            <div class="w-[70%] p-8 relative flex flex-col bg-white">
                <div class="text-5xl font-serif italic font-bold text-[#1e3a8a] mb-8 opacity-90 drop-shadow-sm print:drop-shadow-none">Rx,</div>
                
                <div class="flex-1 space-y-5">
                    @forelse($appointment->prescription->prescriptionMedicines as $index => $medicineData)
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
        <!-- Footer Note -->
        <div class="border-t-2 border-[#1e3a8a] bg-[#e6f0fa] py-2 text-center text-xs text-red-600 font-semibold shadow-inner print:shadow-none print:bg-white print:border-slate-300" style="font-family: 'SolaimanLipi', serif;">
            দিন পর আসবেন, সাক্ষাতের সময় ব্যবস্থাপত্র সাথে আনবেন।<br>
            <span class="text-[10px] text-slate-600 font-normal">বিঃ দ্রঃ অনলাইনে কোনো রোগী দেখা হয়না ও ঔষধ পাঠানো হয়না। শুধুমাত্র সরাসরি চেম্বারে রোগী দেখা হয়।</span>
        </div>
    </div>
    @endif
</div>

<script>
    const appointmentReportFiles = document.getElementById('appointmentReportFiles');
    const appointmentReportsPreview = document.getElementById('appointmentReportsPreview');

    function updateAppointmentReportsPreview() {
        if (!appointmentReportFiles || !appointmentReportsPreview) return;

        appointmentReportsPreview.innerHTML = '';
        const files = appointmentReportFiles.files;
        const emptyMessage = document.getElementById('appointmentReportsEmpty');

        if (!files || files.length === 0) {
            if (emptyMessage) {
                appointmentReportsPreview.appendChild(emptyMessage);
            } else {
                appointmentReportsPreview.innerHTML = '<div class="col-span-full text-center py-8 text-slate-500 text-sm border-2 border-dashed border-slate-200 rounded-lg">Select reports to see preview before upload.</div>';
            }
            return;
        }

        Array.from(files).forEach((file, index) => {
            const card = document.createElement('div');
            card.className = 'bg-white rounded-lg border border-slate-200 overflow-hidden hover:shadow-md transition-all duration-150';

            const preview = document.createElement('div');
            preview.className = 'w-full h-32 flex items-center justify-center bg-slate-100';

            if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    preview.innerHTML = `<img src="${e.target.result}" class="w-full h-32 object-cover" alt="Report preview">`;
                };
                reader.readAsDataURL(file);
            } else if (file.type === 'application/pdf') {
                preview.innerHTML = '<div class="text-center text-red-600"><svg class="w-10 h-10 mx-auto mb-1" fill="currentColor" viewBox="0 0 20 20"><path d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm0 2h12v10H4V5z"></path></svg><p class="text-xs font-semibold">PDF</p></div>';
            } else {
                preview.innerHTML = '<div class="text-sm text-slate-600">File</div>';
            }

            const footer = document.createElement('div');
            footer.className = 'p-3 bg-slate-50 border-t border-slate-200';
            footer.innerHTML = `<p class="text-xs font-medium text-slate-700 truncate" title="${file.name}">${file.name}</p><p class="text-xs text-slate-500">${(file.size / 1024).toFixed(1)} KB</p>`;

            card.appendChild(preview);
            card.appendChild(footer);
            appointmentReportsPreview.appendChild(card);
        });
    }

    if (appointmentReportFiles) {
        appointmentReportFiles.addEventListener('change', updateAppointmentReportsPreview);
        updateAppointmentReportsPreview();
    }
</script>

<style>
@media print {
    body * { visibility: hidden; }
    #prescriptionContent, #prescriptionContent * { visibility: visible; }
    #prescriptionContent { position: absolute; left: 0; top: 0; width: 100%; }
}
</style>
@endsection
