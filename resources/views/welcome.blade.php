@extends('layouts.app')

@section('content')
@php
    $normalizeSection = fn($items) => collect($items)
        ->map(fn($item) => is_array($item) ? (object) $item : $item)
        ->filter(fn($item) => is_object($item));

    $heroSections = $normalizeSection($heroSections);
    $aboutSections = $normalizeSection($aboutSections);
    $biographies = $normalizeSection($biographies);
    $services = $normalizeSection($services);
    $education = $normalizeSection($education);
    $reviews = $normalizeSection($reviews);
    $blogs = $normalizeSection($blogs);
    $clinics = $normalizeSection($clinics);
    $sections = collect($sections);
@endphp
<div class="fixed right-6 bottom-6 z-50">
    <button id="translationToggleButton" class="rounded-full bg-brand-600 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-brand-600/20 hover:bg-brand-700 transition-all duration-150">Translate to বাংলা</button>
</div>
@foreach($heroSections as $hero)
<section class="min-h-screen bg-brand-600 text-white">
    <div class="max-w-7xl mx-auto px-6 py-20 lg:py-28 grid lg:grid-cols-2 gap-12 items-center">
        <div>
            <h1 class="text-5xl font-extrabold tracking-tight leading-tight">{{ $hero->title }}</h1>
            @if($hero->subtitle)
                <p class="text-xl opacity-90 mt-6 max-w-2xl">{{ $hero->subtitle }}</p>
            @endif
            <div class="flex flex-wrap gap-4 mt-8">
                @if($hero->button_text && $hero->button_link)
                    <a href="{{ $hero->button_link }}" class="bg-white text-brand-700 hover:bg-slate-100 font-medium px-5 py-3 rounded-lg shadow-sm transition-all duration-150">{{ $hero->button_text }}</a>
                @endif
                <a href="#about" class="border border-white/40 hover:bg-white/10 text-white font-medium px-5 py-3 rounded-lg transition-all duration-150">Learn More</a>
            </div>
            @php
                $facebookPages = json_decode($appSettings['social_facebook_pages'] ?? '[]', true) ?: [];
                $facebookLinks = array_filter(array_merge($facebookPages, [$appSettings['social_facebook'] ?? null]));
                $socialLinks = [
                    'facebook' => $facebookLinks,
                    'twitter' => [$appSettings['social_twitter'] ?? null],
                    'instagram' => [$appSettings['social_instagram'] ?? null],
                    'linkedin' => [$appSettings['social_linkedin'] ?? null],
                    'youtube' => [$appSettings['social_youtube'] ?? null],
                    'tiktok' => [$appSettings['social_tiktok'] ?? null],
                ];
            @endphp
            <div class="mt-10">
                <p class="text-sm uppercase tracking-[0.3em] text-white/70 mb-4">Connect with us</p>
                <div class="flex flex-wrap gap-3">
                    @foreach($socialLinks as $network => $urls)
                        @if($network === 'facebook')
                            @foreach($urls as $url)
                                <a href="{{ $url }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center justify-center h-12 w-12 rounded-full bg-white/10 border border-white/20 text-white hover:bg-white/20 transition-all duration-150">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M22 12a10 10 0 10-11.5 9.9V14.9h-2.1v-2.9h2.1V10c0-2.1 1.3-3.2 3.1-3.2.9 0 1.8.1 1.8.1v2h-1c-1 0-1.3.6-1.3 1.2v1.5h2.3l-.4 2.9h-1.9v7A10 10 0 0022 12"></path></svg>
                                </a>
                            @endforeach
                        @else
                            @php $url = $urls[0]; $buttonClass = $url && $url !== null && $url !== '' ? 'bg-white/10 border-white/20 text-white hover:bg-white/20' : 'bg-white/5 border-white/10 text-white/50 cursor-not-allowed'; @endphp
                            @if($url && ($url !== null && $url !== ''))
                                <a href="{{ $url }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center justify-center h-12 w-12 rounded-full {{ $buttonClass }} transition-all duration-150">
                            @else
                                <div class="inline-flex items-center justify-center h-12 w-12 rounded-full {{ $buttonClass }} transition-all duration-150" title="{{ ucfirst($network) }}">
                            @endif
                                    @if($network === 'youtube')
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M10 15l5.2-3L10 9v6zm11.5-3.5s0-2.5-.2-3.6c-.2-1.2-.8-2.1-1.9-2.7C17.8 4.8 12 4.8 12 4.8h0s-5.7 0-6.4.4c-1.1.6-1.7 1.5-1.9 2.7C3.5 9.1 3.5 11.5 3.5 11.5s0 2.4.2 3.6c.2 1.2.8 2.1 1.9 2.7.7.4 6.4.4 6.4.4s5.7 0 6.4-.4c1.1-.6 1.7-1.5 1.9-2.7.2-1.1.2-3.6.2-3.6z"></path></svg>
                                    @elseif($network === 'tiktok')
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M18.5 3h-3.4v10.1c0 2.7-2 4.9-4.7 5-2.4.2-4.5-1.8-4.7-4.2-.2-2.4 1.8-4.4 4.2-4.7.6-.1 1.1-.1 1.7 0v2.2c-.4-.1-.8-.1-1.2 0-1.3.2-2.3 1.4-2.1 2.7.2 1.4 1.4 2.4 2.8 2.3 1.5-.1 2.7-1.4 2.7-2.9V3h3.4V3z"></path></svg>
                                    @elseif($network === 'instagram')
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M7 2C4.2 2 2 4.2 2 7v10c0 2.8 2.2 5 5 5h10c2.8 0 5-2.2 5-5V7c0-2.8-2.2-5-5-5H7zm0 2h10c1.7 0 3 1.3 3 3v10c0 1.7-1.3 3-3 3H7c-1.7 0-3-1.3-3-3V7c0-1.7 1.3-3 3-3zm5 2.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zm0 2a3.5 3.5 0 110 7 3.5 3.5 0 010-7zm4.75-.75a1.25 1.25 0 11-2.5 0 1.25 1.25 0 012.5 0z"></path></svg>
                                    @elseif($network === 'linkedin')
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M4.98 3.5C4.98 4.88 3.86 6 2.5 6S0 4.88 0 3.5 1.12 1 2.5 1 4.98 2.12 4.98 3.5zM.5 24h4V8.9h-4V24zm7.5-15.1h3.8v2.1h.1c.5-.9 1.8-1.9 3.7-1.9 4 0 4.8 2.7 4.8 6.2V24h-4V16.3c0-1.8 0-4.1-2.5-4.1-2.5 0-2.9 2-2.9 4v7.8h-4V8.9z"></path></svg>
                                    @elseif($network === 'twitter')
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23 3a10.9 10.9 0 01-3.1.9 5.4 5.4 0 002.4-3 10.8 10.8 0 01-3.4 1.3 5.4 5.4 0 00-9.2 4.9A15.4 15.4 0 012 4.8s-4 8.6 5 12.2a11.6 11.6 0 01-7 2c9 5.6 20 0 20-11.5v-.5A7.7 7.7 0 0023 3z"></path></svg>
                                    @endif
                            @if($url)
                                </a>
                            @else
                                </div>
                            @endif
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
        @if($hero->image_url)
            <div class="relative">
                <div class="absolute -inset-4 bg-white/10 rounded-[2rem] blur-2xl"></div>
                <div class="relative bg-white/10 rounded-[2rem] p-4 border border-white/20 shadow-2xl">
                    <img src="{{ $hero->image_url }}" alt="Doctor portrait" class="w-full h-[560px] object-cover rounded-[1.5rem]">
                </div>
            </div>
        @endif
    </div>
</section>
@endforeach

@foreach($aboutSections as $about)
<section id="about" class="bg-white py-24">
    <div class="max-w-7xl mx-auto px-6 grid lg:grid-cols-2 gap-10 items-stretch">
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-8 flex flex-col h-full">
            <p class="text-xs font-medium text-slate-400 uppercase tracking-wider">About</p>
            <h2 class="text-2xl font-bold text-slate-900 tracking-tight mt-3">{{ $about->title }}</h2>
            @if($about->subtitle)
                <p class="text-sm text-slate-500 mt-2">{{ $about->subtitle }}</p>
            @endif
            <p class="text-sm text-slate-600 mt-5 leading-7">{{ $about->content }}</p>
        </div>
        @if($about->image_url)
            <div class="rounded-2xl overflow-hidden shadow-lg h-full">
                <img src="{{ $about->image_url }}" alt="About" class="w-full h-full object-cover rounded-[1.5rem]">
            </div>
        @endif
    </div>
</section>
@endforeach

@foreach($biographies as $bio)
<section id="bio" class="bg-slate-50 py-20">
    <div class="max-w-7xl mx-auto px-6 grid lg:grid-cols-2 gap-10 items-stretch">
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-8 flex flex-col h-full">
            <p class="text-xs font-medium text-slate-400 uppercase tracking-wider">Biography</p>
            <h2 class="text-2xl font-bold text-slate-900 tracking-tight mt-3">{{ $bio->title }}</h2>
            @if($bio->subtitle)
                <p class="text-sm text-slate-500 mt-2">{{ $bio->subtitle }}</p>
            @endif
            <p class="text-sm text-slate-600 mt-5 leading-7">{{ $bio->content }}</p>
        </div>
        @if($bio->video_url)
            <div class="bg-slate-50 rounded-3xl border border-slate-200 p-6 flex flex-col h-full">
                <div class="aspect-video rounded-2xl overflow-hidden bg-slate-900 shadow-md flex-1">
                    @if($bio->isYoutubeLink($bio->video_url))
                        <iframe src="{{ $bio->video_embed_url }}" class="w-full h-full" allowfullscreen></iframe>
                    @else
                        <video src="{{ $bio->video_embed_url }}" controls class="w-full h-full object-cover"></video>
                    @endif
                </div>
            </div>
        @elseif($bio->youtube_url)
            <div class="bg-slate-50 rounded-3xl border border-slate-200 p-6 flex flex-col h-full">
                <div class="aspect-video rounded-2xl overflow-hidden bg-slate-900 shadow-md flex-1">
                    <iframe src="{{ $bio->youtube_url }}" class="w-full h-full" allowfullscreen></iframe>
                </div>
            </div>
        @endif
    </div>
</section>
@endforeach

<section id="services" class="bg-white py-24 border-t border-slate-100">
    <div class="max-w-7xl mx-auto px-6">
        <div class="max-w-2xl mb-12 text-center mx-auto">
            <p class="text-xs font-medium text-slate-400 uppercase tracking-wider">{{ $sections->get('services')->label ?? 'Services' }}</p>
            <h2 class="text-2xl font-bold text-slate-900 tracking-tight mt-3">{{ $sections->get('services')->title ?? 'Comprehensive medical services' }}</h2>
            <p class="text-sm text-slate-600 mt-4">{{ $sections->get('services')->subtitle ?? 'Designed for modern patients' }}</p>
        </div>
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6 items-stretch">
            @foreach($services as $service)
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 hover:shadow-lg transition-all duration-300 flex flex-col h-full">
                    <div class="w-12 h-12 rounded-2xl bg-brand-50 text-brand-700 flex items-center justify-center mb-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-slate-800">{{ $service->title }}</h3>
                    <p class="text-sm text-slate-600 mt-3 leading-7">{{ $service->description }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

<section id="education" class="bg-slate-50 py-20">
    <div class="max-w-7xl mx-auto px-6">
        <div class="max-w-2xl mb-10 text-center mx-auto">
            <p class="text-xs font-medium text-slate-400 uppercase tracking-wider">{{ $sections->get('education')->label ?? 'Credentials' }}</p>
            <h2 class="text-2xl font-bold text-slate-900 tracking-tight mt-3">{{ $sections->get('education')->title ?? 'Education and certifications' }}</h2>
        </div>
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6 items-stretch">
            @foreach($education as $item)
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 hover:shadow-lg transition-all duration-300 flex flex-col h-full">
                    <span class="bg-orange-50 text-orange-700 border border-orange-200 px-2.5 py-0.5 rounded-full text-xs font-medium">{{ $item->type }}</span>
                    <h3 class="text-lg font-semibold text-slate-800 mt-4">{{ $item->degree }}</h3>
                    <p class="text-sm text-slate-600 mt-2">{{ $item->institution }}</p>
                    <p class="text-sm text-slate-500 mt-2">Completed in {{ $item->year_completed }}</p>
                    @if($item->details)
                        <p class="text-sm text-slate-600 mt-4 leading-6">{{ $item->details }}</p>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</section>

<section id="blog" class="bg-white py-20 border-t border-slate-100">
    <div class="max-w-7xl mx-auto px-6">
        <div class="max-w-2xl mb-10 text-center mx-auto">
            <p class="text-xs font-medium text-slate-400 uppercase tracking-wider">{{ $sections->get('blog')->label ?? 'Blog' }}</p>
            <h2 class="text-2xl font-bold text-slate-900 tracking-tight mt-3">{{ $sections->get('blog')->title ?? 'Health insights' }}</h2>
            <p class="text-sm text-slate-600 mt-4">{{ $sections->get('blog')->subtitle ?? 'Browse articles and videos' }}</p>
        </div>
        <div class="grid gap-6 sm:grid-cols-2 xl:grid-cols-4 pb-4">
                @foreach($blogs as $blog)
                    <article class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden hover:shadow-lg transition-all duration-300 flex flex-col">
                        <img src="{{ $blog->image_url }}" alt="{{ $blog->title }}" class="w-full h-52 object-cover">
                        <div class="p-6 flex-1 flex flex-col">
                            <h3 class="text-lg font-semibold text-slate-900">{{ $blog->title }}</h3>
                            <p class="text-sm text-slate-600 mt-3 leading-7 flex-1">{{ $blog->excerpt }}</p>
                            <div class="mt-5 flex items-center justify-between gap-4 mt-auto">
                                <span class="bg-orange-50 text-orange-700 border border-orange-200 px-2.5 py-0.5 rounded-full text-xs font-medium">Article</span>
                                @if($blog->youtube_url)
                                    <a href="{{ $blog->youtube_url }}" target="_blank" class="bg-brand-600 hover:bg-brand-600/90 text-white font-medium px-4 py-2 rounded-lg shadow-sm transition-all duration-150 text-sm">Open YouTube</a>
                                @endif
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </div>
</section>

<section id="reviews" class="bg-slate-50 py-16">
    <div class="max-w-7xl mx-auto px-6">
        <div class="max-w-2xl mb-10 text-center mx-auto">
            <p class="text-xs font-medium text-slate-400 uppercase tracking-wider">{{ $sections->get('reviews')->label ?? 'Testimonials' }}</p>
            <h2 class="text-2xl font-bold text-slate-900 tracking-tight mt-3">{{ $sections->get('reviews')->title ?? 'Patient experiences' }}</h2>
        </div>
        <div class="grid gap-6 sm:grid-cols-2 xl:grid-cols-4 pb-4">
                @foreach($reviews as $review)
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 hover:shadow-lg transition-all duration-300 flex flex-col">
                        <div class="flex items-center gap-1 text-orange-500 mb-4">
                            @for($i = 0; $i < $review->rating; $i++)
                                <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.539 1.118l-2.8-2.034a1 1 0 00-1.176 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81H7.03a1 1 0 00.95-.69l1.07-3.292z"/></svg>
                            @endfor
                        </div>
                        <p class="text-sm text-slate-600 leading-7 flex-1">"{{ $review->review_text }}"</p>
                        <div class="mt-5 mt-auto">
                            <p class="text-sm font-semibold text-slate-800">{{ $review->patient_name }}</p>
                            <p class="text-xs text-slate-500 mt-1">{{ $review->designation }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

<section id="available-slots" class="bg-white py-20 border-t border-slate-100">
    <div class="max-w-7xl mx-auto px-6">
        <div class="max-w-2xl mb-10 text-center mx-auto">
            <p class="text-xs font-medium text-slate-400 uppercase tracking-wider">Schedule</p>
            <h2 class="text-2xl font-bold text-slate-900 tracking-tight mt-3">Available Consultation Slots</h2>
            <p class="text-sm text-slate-600 mt-4">Visit the doctor at any of our {{ $clinics->count() }} clinic{{ $clinics->count() === 1 ? '' : 's' }} locations based on your convenience.</p>
        </div>
        <div class="flex flex-wrap justify-center gap-6 pb-4">
                @foreach($clinics as $clinic)
                    @foreach($clinic->schedules as $schedule)
                        @if(!$schedule->is_closed)
                            <div class="w-full sm:w-[calc(50%-1.5rem)] xl:w-[calc(25%-1.5rem)] bg-gradient-to-br from-brand-50 to-accent-50 rounded-2xl shadow-sm border border-brand-200 p-6 hover:shadow-lg transition-all duration-300 flex flex-col">
                                <div class="flex items-start justify-between mb-4">
                                    <div class="w-12 h-12 rounded-2xl bg-brand-600 text-white flex items-center justify-center">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                    <span class="bg-emerald-100 text-emerald-700 border border-emerald-300 px-3 py-1 rounded-full text-xs font-bold">OPEN</span>
                                </div>
                                <h3 class="text-xl font-bold text-slate-900 mb-2">{{ $schedule->day_name }}</h3>
                                <p class="text-sm font-semibold text-brand-700 mb-4">{{ $clinic->name }}</p>
                                <div class="flex-1">
                                    <div class="bg-white/80 rounded-xl p-4 mb-4 border border-brand-100">
                                        <div class="flex items-center gap-2 mb-2">
                                            <svg class="w-5 h-5 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            <span class="text-sm font-semibold text-slate-700">Consultation Hours</span>
                                        </div>
                                        <p class="text-lg font-bold text-slate-900">{{ \Carbon\Carbon::createFromFormat('H:i:s', $schedule->start_time)->format('g:i A') }} - {{ \Carbon\Carbon::createFromFormat('H:i:s', $schedule->end_time)->format('g:i A') }}</p>
                                    </div>
                                    <div class="space-y-2 text-xs text-slate-600">
                                        <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                        <span>{{ $clinic->address }}, {{ $clinic->city }}</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                        </svg>
                                        <span>{{ data_get($clinic, 'phones.0') }}</span>
                                    </div>
                                </div>
                                </div>
                                <a href="{{ $sections->get('contact')->button_link ?? '#book' }}" class="mt-4 w-full bg-brand-600 hover:bg-brand-700 text-white font-medium px-4 py-2.5 rounded-lg shadow-sm transition-all duration-150 text-center block">{{ $sections->get('contact')->button_text ?? 'Book This Slot' }}</a>
                            </div>
                        @endif
                    @endforeach
                @endforeach
            </div>
        </div>
    </div>
</section>

<section id="contact" class="bg-slate-50 py-20">
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-10">
            <p class="text-xs font-medium text-slate-400 uppercase tracking-wider">{{ $sections->get('contact')->label ?? 'Contact' }}</p>
            <h2 class="text-2xl font-bold text-slate-900 tracking-tight mt-3">{{ $sections->get('contact')->title ?? 'Reach out for appointments' }}</h2>
            @if($sections->get('contact')->subtitle)
                <p class="text-sm text-slate-500 mt-4">{{ $sections->get('contact')->subtitle }}</p>
            @endif
            @if($sections->get('contact')->content)
                <p class="text-sm text-slate-600 mt-5 leading-7">{{ $sections->get('contact')->content }}</p>
            @endif
        </div>

        <div class="grid lg:grid-cols-[1.2fr_0.8fr] gap-8 items-stretch">
            <div class="space-y-6 h-full flex flex-col">
                <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-8 flex flex-col h-full">
                    <div class="flex items-center justify-between gap-4 mb-8">
                        <div>
                            <p class="text-xs uppercase tracking-wider text-slate-400">Active clinic locations</p>
                            <h3 class="text-xl font-bold text-slate-900 mt-2">Available clinics</h3>
                        </div>
                        <span class="inline-flex items-center rounded-full bg-emerald-100 text-emerald-700 px-3 py-1 text-xs font-semibold">{{ $clinics->where('is_active', true)->count() }} active</span>
                    </div>

                    <div class="flex flex-col gap-6">
                        @forelse($clinics->where('is_active', true) as $clinic)
                            <div class="rounded-3xl border border-slate-200 overflow-hidden bg-white shadow-sm flex flex-col flex-1">
                                <div class="p-6 flex-1">
                                    <h4 class="text-lg font-bold text-slate-900">{{ $clinic->name }}</h4>
                                    <p class="text-sm text-slate-500 mt-2">{{ $clinic->address }}, {{ $clinic->city }}</p>
                                    <div class="mt-4 space-y-2 text-sm text-slate-700">
                                        <div>
                                            <p class="font-medium text-slate-900">Phone</p>
                                            @forelse($clinic->phones as $phone)
                                                <a href="tel:{{ preg_replace('/\s+/', '', $phone) }}" class="text-brand-600 hover:text-brand-700 block">{{ $phone }}</a>
                                            @empty
                                                <p class="text-slate-500">Not available</p>
                                            @endforelse
                                        </div>
                                    </div>
                                </div>
                                @if($clinic->map_embed_url)
                                    <div class="w-full h-32 bg-slate-100 border-t border-slate-200">
                                        <iframe src="{{ $clinic->map_iframe_url }}" class="w-full h-full border-0" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                                    </div>
                                @else
                                    <div class="w-full h-32 flex items-center justify-center bg-slate-100 text-slate-500 border-t border-slate-200">
                                        Map preview not available
                                    </div>
                                @endif
                            </div>
                        @empty
                            <div class="rounded-3xl border border-slate-200 p-8 text-center text-slate-500">
                                No active clinic locations available at this time.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <div id="book" class="bg-white rounded-3xl shadow-md border border-slate-100 p-8 flex flex-col h-full">
                <p class="text-xs font-medium text-slate-400 uppercase tracking-wider">{{ $sections->get('contact')->label ?? 'Book Appointment' }}</p>
                <h2 class="text-2xl font-bold text-slate-900 tracking-tight mt-3">{{ $sections->get('contact')->title ?? 'Request a consultation' }}</h2>
                @if($sections->get('contact')->content)
                    <p class="text-sm text-slate-600 mt-4">{{ $sections->get('contact')->content }}</p>
                @endif
                @if(isset($errors) && $errors->any())
                    <div class="mt-5 bg-red-50 text-red-700 border border-red-200 px-4 py-3 rounded-2xl text-sm">
                        Please review the form.
                    </div>
                @endif

                <div id="patientModeToggle" class="mt-6">
                    <div class="flex gap-2">
                        <button type="button" id="newPatientButton" class="inline-flex items-center justify-center rounded-lg border border-brand-600 bg-brand-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition-all duration-150">New Patient</button>
                        <button type="button" id="existingPatientButton" class="inline-flex items-center justify-center rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-semibold text-slate-700 shadow-sm transition-all duration-150">Existing Patient</button>
                    </div>
                    <div id="existingPatientSection" class="mt-4 hidden rounded-3xl border border-slate-200 bg-slate-50 p-4">
                        <p class="text-sm text-slate-600 mb-3">Enter your existing Patient UID from a previous appointment.</p>
                        <div class="flex flex-col gap-3 sm:flex-row">
                            <input type="text" id="existingPatientUid" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-brand-600/20 focus:border-brand-600 transition-all duration-150" placeholder="Patient UID">
                            <button type="button" id="lookupPatientButton" class="inline-flex items-center justify-center rounded-lg bg-brand-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition-all duration-150">Find Patient</button>
                        </div>
                        <p id="existingPatientMessage" class="mt-2 text-sm text-red-500"></p>
                    </div>
                </div>

                <form action="{{ route('appointments.store') }}" method="POST" class="mt-6">
                    @csrf
                    <input type="hidden" id="patientUid" name="patient_uid" value="{{ old('patient_uid') }}">
                    <input type="hidden" id="sexFallback" value="{{ old('sex') }}">
                    <div class="grid md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1.5">Full Name <span class="text-red-500">*</span></label>
                            <input type="text" id="patientName" data-existing-disable="true" name="patient_name" value="{{ old('patient_name') }}" placeholder="Your full name" class="patient-info-field w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-brand-600/20 focus:border-brand-600 transition-all duration-150" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1.5">Phone Number <span class="text-red-500">*</span></label>
                            <input type="text" id="patientPhone" data-existing-disable="true" name="phone" value="{{ old('phone') }}" placeholder="Phone number" class="patient-info-field w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-brand-600/20 focus:border-brand-600 transition-all duration-150" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1.5">Email (optional)</label>
                            <input type="email" id="patientEmail" name="email" value="{{ old('email') }}" placeholder="Email (optional)" class="patient-info-field w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-brand-600/20 focus:border-brand-600 transition-all duration-150">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1.5">Age <span class="text-red-500">*</span></label>
                            <input type="text" id="patientAge" name="patient_age" value="{{ old('patient_age') }}" placeholder="Age" class="patient-info-field w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-brand-600/20 focus:border-brand-600 transition-all duration-150" required>
                            @error('patient_age')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1.5">Gender <span class="text-red-500">*</span></label>
                            <select id="sexSelect" data-existing-disable="true" name="sex" class="patient-info-field w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-brand-600/20 focus:border-brand-600 transition-all duration-150" required>
                                <option value="">Select gender</option>
                                <option value="Male" @selected(old('sex') === 'Male')>Male</option>
                                <option value="Female" @selected(old('sex') === 'Female')>Female</option>
                                <option value="Other" @selected(old('sex') === 'Other')>Other</option>
                            </select>
                            @error('sex')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1.5">Select Clinic <span class="text-red-500">*</span></label>
                            <select name="clinic_id" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-brand-600/20 focus:border-brand-600 transition-all duration-150" required><option value="">Select clinic</option>@foreach($clinics as $clinic)<option value="{{ $clinic->id }}" @selected(old('clinic_id') == $clinic->id)>{{ $clinic->name }}</option>@endforeach</select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1.5">Appointment Date <span class="text-red-500">*</span></label>
                            <input type="date" name="appointment_date" value="{{ old('appointment_date') }}" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-brand-600/20 focus:border-brand-600 transition-all duration-150" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1.5">Appointment Time <span class="text-red-500">*</span></label>
                            <input type="time" name="appointment_time" value="{{ old('appointment_time') }}" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-brand-600/20 focus:border-brand-600 transition-all duration-150" required>
                        </div>
                    </div>
                    <div class="mt-5">
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Reason for visit <span class="text-red-500">*</span></label>
                        <textarea name="reason" rows="4" placeholder="Reason for visit" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-brand-600/20 focus:border-brand-600 transition-all duration-150" required>{{ old('reason') }}</textarea>
                    </div>
                    <button class="mt-6 bg-brand-600 hover:bg-brand-600/90 text-white font-medium px-4 py-2 rounded-lg shadow-sm transition-all duration-150">{{ $sections->get('contact')->button_text ?? 'Submit Request' }}</button>
                </form>
            </div>
        </div>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const newPatientButton = document.getElementById('newPatientButton');
        const existingPatientButton = document.getElementById('existingPatientButton');
        const existingPatientSection = document.getElementById('existingPatientSection');
        const existingPatientUid = document.getElementById('existingPatientUid');
        const lookupPatientButton = document.getElementById('lookupPatientButton');
        const existingPatientMessage = document.getElementById('existingPatientMessage');
        const patientUidInput = document.getElementById('patientUid');
        const sexSelect = document.getElementById('sexSelect');
        const sexFallback = document.getElementById('sexFallback');
        const patientLockFields = Array.from(document.querySelectorAll('[data-existing-disable]'));
        const patientLookupUrlBase = '{{ url('/appointments/patient') }}';
        const startExistingMode = '{{ old('patient_uid') ? '1' : '0' }}' === '1';

        function setPatientMode(mode) {
            const selectedClasses = ['border-brand-600', 'bg-brand-600', 'text-white'];
            const unselectedClasses = ['border-slate-300', 'bg-white', 'text-slate-700'];

            function applyClasses(button, classes) {
                button.classList.remove(...selectedClasses, ...unselectedClasses);
                button.classList.add(...classes);
            }

            if (mode === 'existing') {
                existingPatientSection.classList.remove('hidden');
                applyClasses(newPatientButton, unselectedClasses);
                applyClasses(existingPatientButton, selectedClasses);
                setPatientFieldsReadOnly(true);
                setSexFallback(sexSelect.disabled);
            } else {
                existingPatientSection.classList.add('hidden');
                applyClasses(newPatientButton, selectedClasses);
                applyClasses(existingPatientButton, unselectedClasses);
                patientUidInput.value = '';
                existingPatientMessage.textContent = '';
                setPatientFieldsReadOnly(false);
                setSexFallback(false);
            }
        }

        function setPatientFieldsReadOnly(readOnly) {
            patientLockFields.forEach(field => {
                if (field.tagName.toLowerCase() === 'select') {
                    field.disabled = readOnly;
                    field.classList.toggle('bg-slate-100', readOnly);
                } else {
                    field.readOnly = readOnly;
                    field.classList.toggle('bg-slate-100', readOnly);
                }
            });
            sexFallback.name = readOnly ? 'sex' : '';
            if (readOnly) {
                sexFallback.value = sexSelect.value;
            }
        }

        function setSexFallback(enabled) {
            if (enabled) {
                sexFallback.name = 'sex';
                sexFallback.value = sexSelect.value;
            } else {
                sexFallback.name = '';
            }
        }

        function showError(message) {
            existingPatientMessage.textContent = message;
        }

        async function lookupPatient() {
            const uid = existingPatientUid.value.trim();
            if (!uid) {
                showError('Please enter a valid Patient UID.');
                return;
            }
            showError('');
            lookupPatientButton.disabled = true;
            lookupPatientButton.textContent = 'Searching...';

            try {
                const response = await fetch(`${patientLookupUrlBase}/${encodeURIComponent(uid)}`);
                if (!response.ok) {
                    throw new Error('Patient not found');
                }
                const patient = await response.json();
                document.getElementById('patientName').value = patient.name || '';
                document.getElementById('patientPhone').value = patient.phone || '';
                document.getElementById('patientEmail').value = patient.email || '';
                document.getElementById('patientAge').value = patient.patient_age || '';
                sexSelect.value = patient.sex || '';
                patientUidInput.value = patient.uid;
                setSexFallback(true);
                setPatientMode('existing');
                showError('Patient data loaded. Patient fields are now locked.');
            } catch (error) {
                showError('Patient record not found. Please check the UID and try again.');
                patientUidInput.value = '';
            } finally {
                lookupPatientButton.disabled = false;
                lookupPatientButton.textContent = 'Find Patient';
            }
        }

        newPatientButton.addEventListener('click', function () {
            setPatientMode('new');
        });

        existingPatientButton.addEventListener('click', function () {
            setPatientMode('existing');
        });

        lookupPatientButton.addEventListener('click', function () {
            lookupPatient();
        });

        if (startExistingMode) {
            existingPatientUid.value = '{{ old('patient_uid') }}';
            setPatientMode('existing');
            showError('Existing patient mode selected. Click Find Patient to load records.');
        } else {
            setPatientMode('new');
        }

        const translationButton = document.getElementById('translationToggleButton');
        const translationEndpoint = '{{ route('api.translations.lookup') }}';
        const queryParams = new URLSearchParams(window.location.search);
        const storedLanguage = localStorage.getItem('preferredLanguage');
        const initialLanguage = queryParams.get('lang') || storedLanguage || 'en';
        let pageTranslated = false;
        let originalNodeValues = new Map();
        let cachedTranslations = {};

        function setPreferredLanguage(lang) {
            if (window.localStorage) {
                localStorage.setItem('preferredLanguage', lang);
            }
        }

        function updateTranslationButton() {
            translationButton.textContent = pageTranslated ? 'Show in English' : 'Translate to বাংলা';
        }

        if (initialLanguage === 'bn') {
            translatePageToBangla().catch(() => {});
        }

        function showToast(message, type = 'success') {
            const container = document.getElementById('tostter-container');
            if (!container) return;
            const toast = document.createElement('div');
            toast.className = 'tostter-card text-white ' + (type === 'error' ? 'bg-red-600' : 'bg-emerald-600');
            toast.innerHTML = `<div class="flex-1">${message}</div><button type="button" aria-label="Close">×</button>`;
            const closeButton = toast.querySelector('button');
            closeButton.addEventListener('click', () => toast.remove());
            container.appendChild(toast);
            requestAnimationFrame(() => toast.classList.add('show'));
            setTimeout(() => toast.remove(), 5000);
        }

        function collectTextNodes(root) {
            const walker = document.createTreeWalker(root, NodeFilter.SHOW_TEXT, {
                acceptNode(node) {
                    const value = node.nodeValue.trim();
                    if (!value) {
                        return NodeFilter.FILTER_REJECT;
                    }
                    const parent = node.parentElement;
                    if (!parent) {
                        return NodeFilter.FILTER_REJECT;
                    }
                    const skipTags = ['script', 'style', 'noscript', 'svg', 'canvas', 'iframe', 'code', 'pre'];
                    if (skipTags.includes(parent.tagName.toLowerCase())) {
                        return NodeFilter.FILTER_REJECT;
                    }
                    if (parent.closest('[aria-hidden="true"]')) {
                        return NodeFilter.FILTER_REJECT;
                    }
                    return NodeFilter.FILTER_ACCEPT;
                }
            });

            const nodes = [];
            while (walker.nextNode()) {
                nodes.push(walker.currentNode);
            }
            return nodes;
        }

        function restoreOriginalText() {
            originalNodeValues.forEach((originalText, node) => {
                node.nodeValue = originalText;
            });
        }

        async function translatePageToBangla() {
            const textNodes = collectTextNodes(document.body);
            if (!textNodes.length) {
                showToast('No visible text found to translate.', 'error');
                return;
            }

            const sourceTexts = [];
            const textsSet = new Set();

            textNodes.forEach(node => {
                if (!originalNodeValues.has(node)) {
                    originalNodeValues.set(node, node.nodeValue);
                }
                const trimmed = node.nodeValue.trim();
                if (trimmed.length > 1 && !textsSet.has(trimmed)) {
                    textsSet.add(trimmed);
                    sourceTexts.push(trimmed);
                }
            });

            const missing = sourceTexts.filter(text => !cachedTranslations[text]);
            if (!missing.length) {
                applyTranslations(cachedTranslations, textNodes);
                return;
            }

            try {
                translationButton.disabled = true;
                translationButton.textContent = 'Translating...';

                const response = await fetch(translationEndpoint, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({ language: 'bn', texts: missing }),
                });

                if (!response.ok) {
                    throw new Error('Translation service failed.');
                }

                const payload = await response.json();
                Object.assign(cachedTranslations, payload.translations || {});
                applyTranslations(cachedTranslations, textNodes);
            } catch (error) {
                console.error(error);
                showToast('Translation request failed. Please try again later.', 'error');
            } finally {
                translationButton.disabled = false;
                updateTranslationButton();
            }
        }

        function applyTranslations(translations, textNodes) {
            let translatedCount = 0;
            textNodes.forEach(node => {
                const original = originalNodeValues.get(node) || node.nodeValue;
                const translated = translations[original];
                if (translated) {
                    node.nodeValue = translated;
                    translatedCount += 1;
                }
            });

            if (translatedCount > 0) {
                pageTranslated = true;
                setPreferredLanguage('bn');
                updateTranslationButton();
                showToast('Page translated to Bangla.');
            } else {
                showToast('No Bangla translations found for current text nodes.', 'error');
            }
        }

        translationButton.addEventListener('click', async function () {
            if (pageTranslated) {
                restoreOriginalText();
                pageTranslated = false;
                setPreferredLanguage('en');
                updateTranslationButton();
                showToast('Returned to English.');
                return;
            }

            await translatePageToBangla();
        });
    });
</script>

@endsection
