<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $settings['site_name'] ?? 'Doctor Portfolio & Clinic' }}</title>
    <meta name="description" content="{{ $settings['meta_description'] ?? 'Professional medical care and consultation services.' }}">
    <meta name="keywords" content="{{ $settings['meta_keywords'] ?? 'doctor, clinic, medical, healthcare' }}">
    @if(!empty($settings['favicon_url']))
        <link rel="icon" href="{{ $settings['favicon_url'] }}">
    @endif
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    colors: {
                        primary: '#093C5D',
                        secondary: '#3B7597',
                        brand: {
                            50: '#F4F8FB',
                            100: '#E9F1F6',
                            200: '#D5E4EE',
                            500: '#093C5D',
                            600: '#093C5D',
                            700: '#072D4B',
                            800: '#062A47'
                        },
                        accent: {
                            50: '#EAF2F7',
                            500: '#3B7597',
                            600: '#3B7597',
                            700: '#316582'
                        }
                    }
                }
            }
        }
    </script>
    <style>
        :root {
            --color-primary: #093C5D;
            --color-secondary: #3B7597;
            --color-background: #F4F8FB;
            --color-surface: #FFFFFF;
            --color-text-primary: #102A43;
            --color-text-secondary: #486581;
            --color-border: #D9E2EC;
            --color-success: #2E8B57;
            --color-error: #D64545;
            --brand-primary: {{ $settings['primary_color'] ?? '#093C5D' }};
            --brand-secondary: {{ $settings['secondary_color'] ?? '#3B7597' }};
        }
        .bg-background { background-color: var(--color-background); }
        .bg-surface { background-color: var(--color-surface); }
        .text-primary { color: var(--color-text-primary); }
        .text-secondary { color: var(--color-text-secondary); }
        .border-theme { border-color: var(--color-border); }
        .border-surface { border-color: var(--color-border); }
        .bg-brand-600 { background-color: var(--brand-primary) !important; }
        .text-brand-700 { color: var(--brand-primary) !important; }
        .border-brand-200 { border-color: var(--brand-primary) !important; }
        .bg-accent-600 { background-color: var(--brand-secondary) !important; }
        .text-accent-400 { color: var(--brand-secondary) !important; }
        .bg-primary-soft { background-color: rgba(9, 60, 93, 0.08); }
        .bg-secondary-soft { background-color: rgba(59, 117, 151, 0.12); }
        .notice-bar { overflow: hidden; }
        .notice-marquee { display: inline-flex; white-space: nowrap; animation: marquee 16s linear infinite; }
        @keyframes marquee { 0% { transform: translateX(100%); } 100% { transform: translateX(-100%); } }
        .tostter-container { position: fixed; top: 1rem; right: 1rem; z-index: 9999; display: flex; flex-direction: column; gap: 0.75rem; }
        .tostter-card { min-width: 300px; max-width: 360px; display: flex; align-items: flex-start; gap: 0.75rem; padding: 1rem 1rem; border-radius: 1rem; box-shadow: 0 20px 50px rgba(15, 23, 42, 0.12); opacity: 0; transform: translateY(0.75rem); transition: transform 180ms ease, opacity 180ms ease; pointer-events: auto; }
        .tostter-card.show { opacity: 1; transform: translateY(0); }
        .tostter-card button { background: transparent; border: none; color: inherit; cursor: pointer; font-size: 1.1rem; line-height: 1; }
    </style>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
</head>
<body class="font-sans antialiased bg-background text-primary">
    @if(!empty($settings['top_notice']))
        <div class="notice-bar bg-brand-600 text-white text-sm">
            <div class="max-w-7xl mx-auto px-6 py-3">
                <div class="notice-marquee">
                    <span class="inline-flex items-center gap-2">{{ $settings['top_notice'] }}</span>
                    <span class="inline-flex items-center gap-2">{{ $settings['top_notice'] }}</span>
                </div>
            </div>
        </div>
    @endif
    <div id="tostter-container" class="tostter-container"></div>
    <nav class="sticky top-0 bg-surface border-b border-theme shadow-sm z-10">
        <div class="max-w-7xl mx-auto px-6 h-16 flex items-center justify-between">
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                @if(!empty($settings['logo_url']))
                    <img src="{{ $settings['logo_url'] }}" alt="Logo" class="h-10 w-auto">
                @else
                    <div class="w-10 h-10 rounded-xl bg-brand-50 text-brand-700 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4.5 12.75l6 6 9-13.5"></path>
                        </svg>
                    </div>
                @endif
                <div>
                    <p class="text-sm font-semibold text-slate-900">{{ $settings['logo_text'] ?? 'Dr. Portfolio' }}</p>
                    <p class="text-xs text-slate-500">{{ $settings['site_tagline'] ?? 'Medical Care' }}</p>
                </div>
            </a>
            <div class="hidden md:flex items-center gap-8 text-sm font-medium text-slate-600">
                <a href="#about" class="hover:text-brand-700 transition">About</a>
                <a href="#services" class="hover:text-brand-700 transition">Services</a>
                <a href="#available-slots" class="hover:text-brand-700 transition">Schedule</a>
                <a href="#reviews" class="hover:text-brand-700 transition">Reviews</a>
                <a href="#contact" class="hover:text-brand-700 transition">Contact</a>
            </div>
            <a href="#book" class="bg-brand-600 hover:bg-brand-600/90 text-white font-medium px-4 py-2 rounded-lg shadow-sm transition-all duration-150">Book Now</a>
        </div>
    </nav>

    @yield('content')

    <footer class="bg-slate-900 text-slate-400 py-16 relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-slate-800/50 to-slate-900/50"></div>
        <div class="relative max-w-7xl mx-auto px-6">
            <div class="grid md:grid-cols-3 gap-12 text-center">
                <div>
                    <div class="w-12 h-12 rounded-full bg-brand-600/20 flex items-center justify-center mx-auto mb-4">
                        <svg class="w-6 h-6 text-brand-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                        </svg>
                    </div>
                    <h3 class="text-sm font-semibold text-white mb-4">Quick Links</h3>
                    <ul class="space-y-3 text-sm">
                        <li><a href="#about" class="hover:text-brand-400 transition-colors duration-200 flex items-center justify-center gap-2"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>About Doctor</a></li>
                        <li><a href="#services" class="hover:text-brand-400 transition-colors duration-200 flex items-center justify-center gap-2"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>Services</a></li>
                        <li><a href="#education" class="hover:text-brand-400 transition-colors duration-200 flex items-center justify-center gap-2"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path></svg>Education</a></li>
                    </ul>
                </div>
                <div>
                    <div class="w-12 h-12 rounded-full bg-accent-600/20 flex items-center justify-center mx-auto mb-4">
                        <svg class="w-6 h-6 text-accent-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-sm font-semibold text-white mb-4">Patient Care</h3>
                    <ul class="space-y-3 text-sm">
                        <li><a href="#book" class="hover:text-accent-400 transition-colors duration-200 flex items-center justify-center gap-2"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>Book Appointment</a></li>
                        <li><a href="#available-slots" class="hover:text-accent-400 transition-colors duration-200 flex items-center justify-center gap-2"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>Available Slots</a></li>
                        <li><a href="#reviews" class="hover:text-accent-400 transition-colors duration-200 flex items-center justify-center gap-2"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.539 1.118l-2.8-2.034a1 1 0 00-1.176 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81H7.03a1 1 0 00.95-.69l1.07-3.292z"></path></svg>Patient Reviews</a></li>
                    </ul>
                </div>
                <div>
                    <div class="w-12 h-12 rounded-full bg-secondary/20 flex items-center justify-center mx-auto mb-4">
                        <svg class="w-6 h-6 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-sm font-semibold text-white mb-4">Information</h3>
                    <ul class="space-y-3 text-sm">
                        <li><a href="#bio" class="hover:text-white transition-colors duration-200 flex items-center justify-center gap-2"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>Biography</a></li>
                        <li><a href="#blog" class="hover:text-white transition-colors duration-200 flex items-center justify-center gap-2"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>Health Articles</a></li>
                        <li><a href="#contact" class="hover:text-white transition-colors duration-200 flex items-center justify-center gap-2"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>Contact Us</a></li>
                        <li><a href="{{ route('admin.login') }}" class="hover:text-white transition-colors duration-200 flex items-center justify-center gap-2"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>Admin Login</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-slate-700 mt-12 pt-8 text-center">
                <p class="text-xs">© {{ date('Y') }} {{ $settings['footer_text'] ?? 'Company Name. All rights reserved.' }}</p>
                <p class="mt-2 text-xs">Made By <span class="text-red-400"> ♥ </span><a href='http://rawshankabir.com/' target='_blank' class='hover:text-brand-400 transition-colors duration-200 hover:underline'>Mr. Kabir</a></p>
            </div>
        </div>
    </footer>

    <script>
        function Tostter(type, message, duration = 5000) {
            const container = document.getElementById('tostter-container');
            if (!container || !message) return;
            const toast = document.createElement('div');
            toast.className = 'tostter-card text-white';
            const bg = type === 'success' ? 'bg-emerald-600' : type === 'error' ? 'bg-red-600' : 'bg-slate-900';
            toast.classList.add(...bg.split(' '));
            toast.innerHTML = `<div class="flex-1">${message}</div><button type="button" aria-label="Close">×</button>`;
            const closeButton = toast.querySelector('button');
            closeButton.addEventListener('click', () => toast.remove());
            container.appendChild(toast);
            requestAnimationFrame(() => toast.classList.add('show'));
            setTimeout(() => toast.remove(), duration);
        }

        document.addEventListener('DOMContentLoaded', function () {
            @if(session('success'))
                Tostter('success', @json(session('success')));
            @endif
            @if(session('error'))
                Tostter('error', @json(session('error')));
            @endif
        });
    </script>
</body>
</html>
