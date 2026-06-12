<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Admin Panel' }}</title>
    @if (file_exists(public_path('build/manifest.json')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        colors: {
                            brand: {
                                50: '#eaf4fb',
                                100: '#d3e8f7',
                                200: '#a7d0ee',
                                300: '#7ab7e4',
                                400: '#4f95cc',
                                500: '#3b7597',
                                600: '#305f77',
                                700: '#264955',
                                800: '#1c3340',
                                900: '#10212a',
                            },
                        },
                        fontFamily: { sans: ['Inter', 'sans-serif'] },
                    },
                },
            }
        </script>
    @endif
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        .tostter-container { position: fixed; top: 1rem; right: 1rem; z-index: 9999; display: flex; flex-direction: column; gap: 0.75rem; pointer-events: none; }
        .tostter-card { min-width: 300px; max-width: 360px; display: flex; align-items: flex-start; gap: 0.75rem; padding: 1rem; border-radius: 1rem; box-shadow: 0 20px 50px rgba(15, 23, 42, 0.12); opacity: 0; transform: translateY(0.75rem); transition: transform 180ms ease, opacity 180ms ease; pointer-events: auto; }
        .tostter-card.show { opacity: 1; transform: translateY(0); }
        .tostter-card button { background: transparent; border: none; color: inherit; cursor: pointer; font-size: 1.1rem; line-height: 1; }
    <style>
        .tostter-container { position: fixed; top: 1rem; right: 1rem; z-index: 9999; display: flex; flex-direction: column; gap: 0.75rem; pointer-events: none; }
        .tostter-card { min-width: 300px; max-width: 360px; display: flex; align-items: flex-start; gap: 0.75rem; padding: 1rem; border-radius: 1rem; box-shadow: 0 20px 50px rgba(15, 23, 42, 0.12); opacity: 0; transform: translateY(0.75rem); transition: transform 180ms ease, opacity 180ms ease; pointer-events: auto; }
        .tostter-card.show { opacity: 1; transform: translateY(0); }
        .tostter-card button { background: transparent; border: none; color: inherit; cursor: pointer; font-size: 1.1rem; line-height: 1; }
    </style>
</head>
<body class="font-sans antialiased bg-[#F3F9FF] text-slate-900">
    <div id="tostter-container" class="tostter-container"></div>
    <aside class="fixed h-screen w-64 bg-white border-r border-slate-200 flex flex-col z-10 overflow-y-auto shadow-sm">
        <div class="px-6 py-5 border-b border-slate-100">
            <div class="flex items-center gap-3">
                <div class="w-11 h-11 rounded-2xl bg-brand-50 text-brand-700 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 4v16m8-8H4"></path>
                    </svg>
                </div>
                <div>
                    <p class="font-semibold text-slate-900">Clinic Admin</p>
                    <p class="text-xs text-slate-500">Doctor Workspace</p>
                </div>
            </div>
        </div>

        <div class="px-5 pt-5 pb-1.5 text-xs font-semibold text-slate-400 uppercase tracking-wider">Overview</div>
        <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium bg-brand-50 text-brand-700 mx-2 my-0.5' : 'flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-slate-700 hover:bg-slate-100 hover:text-slate-900 transition-all duration-150 mx-2 my-0.5' }}"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>Dashboard</a>

        <div class="px-5 pt-5 pb-1.5 text-xs font-semibold text-slate-400 uppercase tracking-wider">Content</div>
        <a href="{{ route('admin.hero.index') }}" class="{{ request()->routeIs('admin.hero.*') ? 'flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium bg-brand-50 text-brand-700 mx-2 my-0.5' : 'flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-slate-700 hover:bg-slate-100 hover:text-slate-900 transition-all duration-150 mx-2 my-0.5' }}"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/></svg>Hero Section</a>
        <a href="{{ route('admin.about.index') }}" class="{{ request()->routeIs('admin.about.*') ? 'flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium bg-brand-50 text-brand-700 mx-2 my-0.5' : 'flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-slate-700 hover:bg-slate-100 hover:text-slate-900 transition-all duration-150 mx-2 my-0.5' }}"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>About Section</a>
        <a href="{{ route('admin.biography.index') }}" class="{{ request()->routeIs('admin.biography.*') ? 'flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium bg-brand-50 text-brand-700 mx-2 my-0.5' : 'flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-slate-700 hover:bg-slate-100 hover:text-slate-900 transition-all duration-150 mx-2 my-0.5' }}"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>Biography</a>
        @if(!isset($appSettings['show_portfolio_sections']) || $appSettings['show_portfolio_sections'] === '1')
            <a href="{{ route('admin.sections.index') }}" class="{{ request()->routeIs('admin.sections.*') ? 'flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium bg-brand-50 text-brand-700 mx-2 my-0.5' : 'flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-slate-700 hover:bg-slate-100 hover:text-slate-900 transition-all duration-150 mx-2 my-0.5' }}"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 6h16M4 12h16M4 18h16"/></svg>Portfolio Sections</a>
        @endif
        <a href="{{ route('admin.services.index') }}" class="{{ request()->routeIs('admin.services.*') ? 'flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium bg-brand-50 text-brand-700 mx-2 my-0.5' : 'flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-slate-700 hover:bg-slate-100 hover:text-slate-900 transition-all duration-150 mx-2 my-0.5' }}"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>Services</a>
        <a href="{{ route('admin.education.index') }}" class="{{ request()->routeIs('admin.education.*') ? 'flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium bg-brand-50 text-brand-700 mx-2 my-0.5' : 'flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-slate-700 hover:bg-slate-100 hover:text-slate-900 transition-all duration-150 mx-2 my-0.5' }}"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422A12.083 12.083 0 0112 20.055a12.083 12.083 0 01-6.16-9.477L12 14z"/></svg>Education</a>
        <a href="{{ route('admin.blogs.index') }}" class="{{ request()->routeIs('admin.blogs.*') ? 'flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium bg-brand-50 text-brand-700 mx-2 my-0.5' : 'flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-slate-700 hover:bg-slate-100 hover:text-slate-900 transition-all duration-150 mx-2 my-0.5' }}"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 5H5a2 2 0 00-2 2v10a2 2 0 002 2h14a2 2 0 002-2V7a2 2 0 00-2-2zM7 9h10M7 13h6"/></svg>Blogs</a>
        <a href="{{ route('admin.reviews.index') }}" class="{{ request()->routeIs('admin.reviews.*') ? 'flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium bg-brand-50 text-brand-700 mx-2 my-0.5' : 'flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-slate-700 hover:bg-slate-100 hover:text-slate-900 transition-all duration-150 mx-2 my-0.5' }}"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.539 1.118l-2.8-2.034a1 1 0 00-1.176 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81H7.03a1 1 0 00.95-.69l1.07-3.292z"/></svg>Reviews</a>

        <div class="px-5 pt-5 pb-1.5 text-xs font-semibold text-slate-400 uppercase tracking-wider">Operations</div>
        <a href="{{ route('admin.clinics.index') }}" class="{{ request()->routeIs('admin.clinics.*') ? 'flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium bg-brand-50 text-brand-700 mx-2 my-0.5' : 'flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-slate-700 hover:bg-slate-100 hover:text-slate-900 transition-all duration-150 mx-2 my-0.5' }}"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>Clinics</a>
        <a href="{{ route('admin.patients.index') }}" class="{{ request()->routeIs('admin.patients.*') ? 'flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium bg-brand-50 text-brand-700 mx-2 my-0.5' : 'flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-slate-700 hover:bg-slate-100 hover:text-slate-900 transition-all duration-150 mx-2 my-0.5' }}"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M5 12a7 7 0 1114 0 7 7 0 01-14 0zm7-5a3 3 0 100 6 3 3 0 000-6zm0 11c-3.866 0-7 1.567-7 3.5V21h14v.5c0-1.933-3.134-3.5-7-3.5z"/></svg>Patients</a>
        <a href="{{ route('admin.schedules.index') }}" class="{{ request()->routeIs('admin.schedules.*') ? 'flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium bg-brand-50 text-brand-700 mx-2 my-0.5' : 'flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-slate-700 hover:bg-slate-100 hover:text-slate-900 transition-all duration-150 mx-2 my-0.5' }}"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>Schedules</a>
        <a href="{{ route('admin.appointments.index') }}" class="{{ request()->routeIs('admin.appointments.*') ? 'flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium bg-brand-50 text-brand-700 mx-2 my-0.5' : 'flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-slate-700 hover:bg-slate-100 hover:text-slate-900 transition-all duration-150 mx-2 my-0.5' }}"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>Appointments</a>
        <a href="{{ route('admin.medicines.index') }}" class="{{ request()->routeIs('admin.medicines.*') ? 'flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium bg-brand-50 text-brand-700 mx-2 my-0.5' : 'flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-slate-700 hover:bg-slate-100 hover:text-slate-900 transition-all duration-150 mx-2 my-0.5' }}"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>Medicines</a>
        <a href="{{ route('admin.prescriptions.index') }}" class="{{ request()->routeIs('admin.prescriptions.*') ? 'flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium bg-brand-50 text-brand-700 mx-2 my-0.5' : 'flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-slate-700 hover:bg-slate-100 hover:text-slate-900 transition-all duration-150 mx-2 my-0.5' }}"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 14H5m14-4H5m14-4H5m14 12H5"/></svg>Prescriptions</a>
        <a href="{{ route('admin.roles.index') }}" class="{{ request()->routeIs('admin.roles.*') ? 'flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium bg-brand-50 text-brand-700 mx-2 my-0.5' : 'flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-slate-700 hover:bg-slate-100 hover:text-slate-900 transition-all duration-150 mx-2 my-0.5' }}"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0"/></svg>Roles & Permissions</a>
        <a href="{{ route('admin.settings.index') }}" class="{{ request()->routeIs('admin.settings.*') ? 'flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium bg-brand-50 text-brand-700 mx-2 my-0.5' : 'flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-slate-700 hover:bg-slate-100 hover:text-slate-900 transition-all duration-150 mx-2 my-0.5' }}"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>Settings</a>
        <a href="{{ route('admin.translations.index') }}" class="{{ request()->routeIs('admin.translations.*') ? 'flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium bg-brand-50 text-brand-700 mx-2 my-0.5' : 'flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-slate-700 hover:bg-slate-100 hover:text-slate-900 transition-all duration-150 mx-2 my-0.5' }}"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 5h16M4 12h16M4 19h16"/></svg>Translations</a>

        <div class="mt-auto p-4 border-t border-slate-100">
            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button class="w-full bg-white hover:bg-slate-50 text-slate-700 font-medium px-4 py-2 rounded-lg border border-slate-200 transition-all duration-150">Sign Out</button>
            </form>
        </div>
    </aside>

    <main class="ml-64 p-8 bg-[#F3F9FF] min-h-screen">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">{{ $pageTitle ?? 'Admin Panel' }}</h1>
                <p class="text-sm text-slate-500 mt-1">Manage portfolio, clinic operations, prescriptions, and site settings.</p>
            </div>
            <div class="inline-flex items-center gap-3 bg-brand-50 text-brand-700 rounded-full px-4 py-2 text-sm font-medium">
                <span class="w-9 h-9 rounded-full bg-white flex items-center justify-center border border-brand-100">{{ strtoupper(substr(session('admin_user', 'A'), 0, 1)) }}</span>
                {{ session('admin_user', 'Admin') }}
            </div>
        </div>

        @yield('content')
    </main>

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



