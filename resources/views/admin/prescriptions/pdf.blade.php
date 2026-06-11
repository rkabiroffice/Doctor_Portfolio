<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Prescription - {{ $prescription->appointment->patient_name ?? 'Patient' }}</title>
    
    <style>
        /* Base Reset */
        body {
            font-family: 'BanglaFont', 'Helvetica', 'Arial', sans-serif; /* English text fallback */
            margin: 0;
            padding: 0;
            color: #1e293b;
            background-color: #ffffff;
            font-size: 16px;
        }

        /* Apply Bangla font to specific classes */
        .bangla {
            font-family: 'BanglaFont', sans-serif;
        }

        /* Typography & Colors */
        .text-primary { color: #1e3a8a; }
        .text-danger { color: #dc2626; }
        .bg-primary { background-color: #1e3a8a; color: #ffffff; }
        .bg-danger-light { background-color: #fee2e2; }
        .bg-gray { background-color: #f8fafc; }
        .bg-sidebar { background-color: #f4f8fc; }
        
        .font-bold { font-weight: bold; }
        .text-xs { font-size: 12px; }
        .text-sm { font-size: 14px; }
        .text-base { font-size: 16px; }
        .text-lg { font-size: 18px; }
        .text-xl { font-size: 22px; }

        /* Universal Table Reset for Layout */
        table { width: 100%; border-collapse: collapse; border-spacing: 0; }
        td { vertical-align: top; }

        /* Helpers */
        .p-4 { padding: 16px; }
        .p-2 { padding: 8px; }
        .border-bottom { border-bottom: 2px solid #1e3a8a; }
        .border-top { border-top: 2px solid #1e3a8a; }
        .rounded { border-radius: 4px; border: 1px solid #e2e8f0; }
    </style>
</head>
<body>

    <!-- Main Wrapper -->
    <div style="border: 1px solid #e2e8f0; margin: 0 auto; max-width: 800px; width: 100%;">
        <div style="width: 100%;">        
            <!-- HEADER SECTION -->
            <table class="p-4">
                <tr>
                    <!-- Doctor Info (Left) -->
                    <td width="40%" height="220" valign="top" style="padding: 20px;">
                        <h2 class="text-xl font-bold text-primary bangla" style="margin: 0 0 5px 0;">ডাঃ মোঃ রায়হান উদ্দিন</h2>
                        <p class="text-sm font-bold" style="margin: 0 0 5px 0;">এমবিবিএস (সি.ইউ), ডিডি (ইউ.কে)<br>ডিভিএস (চর্ম ও যৌন)</p>
                        <p class="text-xs bangla" style="margin: 0; color: #475569; line-height: 1.4;">
                            সিসিডি (বারডেম-ডায়াবেটিস)<br>
                            এফসিজিপি (ফ্যামিলি মেডিসিন)<br>
                            পিজিটি (মেডিসিন)<br>
                            ঢাকা মেডিকেল কলেজ ও হাসপাতাল<br>
                            ট্রেইন্ড ইন এস্থেটিকস, লেজার, হেয়ার ট্রান্সপ্লান্ট এন্ড ডার্মাটোসার্জারী<br>
                            মাস্টার্স ইন মেল (Male) ইনফার্টিলিটি (ইউএসএ)<br>
                            ফেলোশীপ ইন সেক্সুয়াল মেডিসিন (চেন্নাই, ইন্ডিয়া)।<br>
                            বিএমডিসি রেজিঃ <strong style="font-family: Arial;">A-81796</strong>
                        </p>
                    </td>

                    <!-- Middle Contact (Center) -->
                    <td width="20%" valign="top" align="center" style="border-left: 1px solid #e2e8f0; border-right: 1px solid #e2e8f0; padding: 20px;">
    
                        <div style="margin-bottom: 12px;">
                            <span class="text-xs font-bold text-primary bangla" style="border: 2px solid #1e3a8a; padding: 6px 12px; display: inline-block;">
                                সিরিয়ালের জন্য :
                            </span>
                        </div>
                        
                        <p class="text-base font-bold text-danger" style="margin: 5px 0 5px 0; font-family: Arial, sans-serif;">
                            01647-386185<br>01727-375664
                        </p>
                        
                        <p class="text-xs bangla" style="margin: 0 0 20px 0; color: #475569;">
                            (সকাল ১১ টা - দুপুর ৩ টা পর্যন্ত)
                        </p>
                        
                        <table width="100%" cellpadding="0" cellspacing="0" style="border: 1px dashed #ef4444; background-color: #fef2f2;">
                            <tr>
                                <td align="center" style="padding: 10px;">
                                    <p class="text-xs font-bold text-danger bangla" style="margin: 0 0 5px 0; border-bottom: 1px solid #fecaca; padding-bottom: 5px;">
                                        রোগী দেখার সময় :
                                    </p>
                                    <p class="text-xs bangla" style="margin: 5px 0 0 0; color: #475569; line-height: 1.4;">
                                        প্রতি বৃহস্পতি, শুক্র ও শনিবার<br>(দুপুর ২টা থেকে রাত ১০টা পর্যন্ত)
                                    </p>
                                </td>
                            </tr>
                        </table>
                        
                    </td>      

                    <!-- Chamber Info (Right) -->
                    <td width="40%" height="220" valign="top" align="right" style="padding: 20px;">
                        <span class="bg-primary bangla" style="padding: 4px 8px; font-size: 11px; font-weight: bold; border-radius: 3px;">চেম্বার :</span>
                        <h3 class="text-lg font-bold text-danger bangla" style="margin: 10px 0 5px 0;">পিওর সায়েন্টিফিক ডায়াগনস্টিক সার্ভিসেস্ লিঃ</h3>
                        <p class="text-sm font-bold text-primary bangla" style="margin: 0 0 15px 0; line-height: 1.4;">
                            ঢাকা মেডিকেল কলেজ ও হাসপাতাল ইউনিট-২<br>
                            (নতুন বিল্ডিং) গেইটের বিপরীত পার্শ্বে,<br>
                            লাজ ফার্মার সাথে, ঢাকা।
                        </p>
                        <table width="100%">
                            <tr>
                                <td align="right" class="text-xs" style="color: #475569;">
                                    <span class="text-danger">YT</span> Dr.Rayhan Uddin<br>
                                    <span style="color: #2563eb; font-weight: bold;">f</span> facebook.com/rayhan.uddin.33
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>

            <!-- Specialties Banner -->
            <div style="background-color: #fce7f3; border-top: 1px solid #fbcfe8; border-bottom: 1px solid #fbcfe8; text-align: center; padding: 6px 0;">
                <p class="text-sm font-bold text-primary bangla" style="margin: 0;">মেডিসিন, ডায়াবেটিস, পুরুষ বন্ধ্যত্ব, এলার্জী, চর্ম ও যৌন রোগে অভিজ্ঞ।</p>
            </div>

            <!-- Patient Info Bar -->
            <table width="100%" class="border-bottom bg-gray" cellpadding="0" cellspacing="0" style="width: 100%;">
                <tr>
                    <td width="20%" style="padding: 5px 0px 5px 10px; vertical-align: middle;">
                        <span class="text-primary font-bold">Patient ID:</span> 
                        <span style="color: #0f172a; font-weight: bold;">{{ $prescription->appointment->patient->uid ?? ' ' }}</span>
                    </td>
                    
                    <td width="25%" style="padding: 5px 0px; vertical-align: middle;">
                        <span class="text-primary font-bold">Name:</span> 
                        <span style="color: #0f172a; font-weight: bold;">{{ $prescription->appointment->patient_name ?? ' ' }}</span>
                    </td>
                    
                    <td width="15%" style="padding: 5px 0px; vertical-align: middle;">
                        <span class="text-primary font-bold">Age:</span> 
                        <span style="color: #0f172a; font-weight: bold;">{{ $prescription->appointment->patient_age ?? ' ' }}</span>
                    </td>
                    
                    <td width="15%" style="padding: 5px 0px; vertical-align: middle;">
                        <span class="text-primary font-bold">Sex:</span> 
                        <span style="color: #0f172a; font-weight: bold;">{{ $prescription->appointment->patient_sex ?? ' ' }}</span>
                    </td>
                    
                    <td width="25%" align="right" style="padding: 5px 10px 5px 0px; vertical-align: middle;">
                        <span class="text-primary font-bold">Date:</span> 
                        <span style="color: #0f172a; font-weight: bold;">{{ $prescription->appointment->appointment_date ? $prescription->appointment->appointment_date->format('d M Y') : ' ' }}</span>
                    </td>
                </tr>
            </table>

            <!-- Main Body Area -->
            <table width="100%">
                <tr>
                    <!-- LEFT SIDEBAR (Vitals & Notes) -->
                    <td width="30%" valign="top" style="background-color: #f8fafc; border-right: 2px solid #1e3a8a; padding: 20px; font-family: Arial, sans-serif;">
    
                        <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom: 15px;">
                            <tr>
                                <td style="color: #1e3a8a; font-weight: bold; font-size: 14px; border-bottom: 1px solid #cbd5e1; padding-bottom: 4px;">C/C:</td>
                            </tr>
                            <tr>
                                <td style="font-size: 12px; padding-top: 6px; color: #334155; line-height: 1.4;">
                                    {!! nl2br(e($prescription->chief_complaint ?: 'None recorded')) !!}
                                </td>
                            </tr>
                        </table>

                        <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom: 20px;">
                            <tr>
                                <td style="color: #1e3a8a; font-weight: bold; font-size: 14px; border-bottom: 1px solid #cbd5e1; padding-bottom: 4px;">O/E:</td>
                            </tr>
                            <tr>
                                <td style="font-size: 12px; padding-top: 6px; color: #334155; line-height: 1.4;">
                                    {!! nl2br(e($prescription->on_examination ?: 'None recorded')) !!}
                                </td>
                            </tr>
                        </table>

                        <table width="100%" cellpadding="8" cellspacing="0" style="background-color: #ffffff; border: 1px solid #e2e8f0; border-top: 3px solid #1e3a8a; margin-bottom: 20px;">
                            <tr>
                                <td width="30%" style="color: #1e3a8a; font-weight: bold; font-size: 12px; border-bottom: 1px solid #f1f5f9;">BP:</td>
                                <td style="font-size: 12px; border-bottom: 1px solid #f1f5f9;">{{ $prescription->bp ?: '-- / --' }} <span style="color:#94a3b8">mmHg</span></td>
                            </tr>
                            <tr>
                                <td style="color: #1e3a8a; font-weight: bold; font-size: 12px; border-bottom: 1px solid #f1f5f9;">P:</td>
                                <td style="font-size: 12px; border-bottom: 1px solid #f1f5f9;">{{ $prescription->pulse ?: '--' }} <span style="color:#94a3b8">Beats/min</span></td>
                            </tr>
                            <tr>
                                <td style="color: #1e3a8a; font-weight: bold; font-size: 12px; border-bottom: 1px solid #f1f5f9;">T:</td>
                                <td style="font-size: 12px; border-bottom: 1px solid #f1f5f9;">{{ $prescription->temperature ?: '--' }} <span style="color:#94a3b8">°F</span></td>
                            </tr>
                            <tr>
                                <td style="color: #1e3a8a; font-weight: bold; font-size: 12px; border-bottom: 1px solid #f1f5f9;">H:</td>
                                <td style="font-size: 12px; border-bottom: 1px solid #f1f5f9;">{{ $prescription->height ?: '--' }} <span style="color:#94a3b8">cm</span></td>
                            </tr>
                            <tr>
                                <td style="color: #1e3a8a; font-weight: bold; font-size: 12px;">L:</td>
                                <td style="font-size: 12px;">{{ $prescription->weight ?: '--' }} <span style="color:#94a3b8">kg</span></td>
                            </tr>
                        </table>

                        <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom: 20px;">
                            <tr>
                                <td style="color: #dc2626; font-weight: bold; font-size: 14px; border-bottom: 1px solid #fecaca; padding-bottom: 4px;">Diagnosis:</td>
                            </tr>
                            <tr>
                                <td style="font-size: 12px; padding-top: 6px; color: #334155; line-height: 1.4;">
                                    {!! nl2br(e($prescription->diagnosis ?: 'Pending')) !!}
                                </td>
                            </tr>
                        </table>

                        <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom: 25px;">
                            <tr>
                                <td style="color: #1e3a8a; font-weight: bold; font-size: 14px; border-bottom: 1px solid #cbd5e1; padding-bottom: 4px;">Advice:</td>
                            </tr>
                            <tr>
                                <td class="bangla" style="font-size: 12px; padding-top: 6px; color: #334155; line-height: 1.5;">
                                    {!! nl2br(e($prescription->advice ?: 'No specific advice given.')) !!}
                                </td>
                            </tr>
                        </table>

                            @if($prescription->follow_up_date)
                            <table width="100%" cellpadding="10" cellspacing="0" style="background-color: #fef2f2; border: 1px dashed #ef4444;">
                                <tr>
                                    <td align="center">
                                        <p style="color: #1e3a8a; font-weight: bold; font-size: 12px; margin: 0 0 5px 0;">Follow Up Date:</p>
                                        <p style="color: #dc2626; font-weight: bold; font-size: 14px; margin: 0;">
                                            {{ \Carbon\Carbon::parse($prescription->follow_up_date)->format('d F Y (l)') }}
                                        </p>
                                    </td>
                                </tr>
                            </table>
                            @endif

                    </td>

                    <!-- RIGHT SIDEBAR (Medicines) -->
                    <td width="70%" height="760" valign="top" style="padding: 30px;">
                        <div style="font-size: 40px; font-family: Georgia, serif; font-style: italic; font-weight: bold; color: #1e3a8a; margin-bottom: 20px; opacity: 0.9;">
                            Rx,
                        </div>

                        <!-- Medicines Loop -->
                        <table width="100%">
                            @forelse($prescription->prescriptionMedicines as $index => $medicineData)
                            <tr>
                                <td width="5%" style="padding-bottom: 20px; border-bottom: 1px solid #f1f5f9;">
                                    <div style="width: 20px; height: 20px; border: 2px solid #1e3a8a; border-radius: 50%; text-align: center; line-height: 20px; font-weight: bold; color: #1e3a8a; font-size: 11px;">
                                        {{ $index + 1 }}
                                    </div>
                                </td>
                                <td width="55%" style="padding-bottom: 20px; border-bottom: 1px solid #f1f5f9; padding-left: 10px;">
                                    <div class="font-bold text-base" style="color: #0f172a; margin-bottom: 5px;">{{ $medicineData->medicine->name ?? 'Unknown Medicine' }}</div>
                                    @if($medicineData->instruction)
                                        <div class="text-xs bangla" style="color: #475569; font-style: italic;">
                                            <span style="font-weight: bold; font-style: normal;">Instruction:</span> {{ $medicineData->instruction }}
                                        </div>
                                    @endif
                                </td>
                                <td width="20%" style="padding-bottom: 20px; border-bottom: 1px solid #f1f5f9; text-align: center;">
                                    <span class="text-primary font-bold text-sm">
                                        {{ $medicineData->morning_dose ?: '0' }} <span style="color:#cbd5e1; font-weight:normal;">+</span> 
                                        {{ $medicineData->afternoon_dose ?: '0' }} <span style="color:#cbd5e1; font-weight:normal;">+</span> 
                                        {{ $medicineData->night_dose ?: '0' }}
                                    </span>
                                </td>
                                <td width="20%" style="padding-bottom: 20px; border-bottom: 1px solid #f1f5f9; text-align: right;">
                                    <span class="font-bold bangla" style="color: #334155; font-size: 13px;">{{ $medicineData->duration }}</span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" align="center" style="padding: 40px; color: #94a3b8; font-style: italic;">
                                    No medicines prescribed.
                                </td>
                            </tr>
                            @endforelse
                        </table>
                    </td>
                </tr>
            </table>

            <!-- Footer -->
            <div class="border-top" style="background-color: #e6f0fa; text-align: center; padding: 15px;">
                <div class="text-danger font-bold bangla" style="font-size: 13px; margin-bottom: 4px;">
                    দিন পর আসবেন, সাক্ষাতের সময় ব্যবস্থাপত্র সাথে আনবেন।
                </div>
                <div class="bangla" style="font-size: 10px; color: #475569;">
                    বিঃ দ্রঃ অনলাইনে কোনো রোগী দেখা হয়না ও ঔষধ পাঠানো হয়না। শুধুমাত্র সরাসরি চেম্বারে রোগী দেখা হয়।
                </div>
            </div>
        </div>
    </div>
</body>
</html>
