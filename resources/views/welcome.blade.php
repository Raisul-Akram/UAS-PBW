<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>BENGKEL SERVIS - Sistem Manajemen Servis Elektronik & Bengkel</title>

    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Alpine.js via CDN -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- GSAP via CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>

    <!-- Custom CSS Keyframes and Animation Classes -->
    <style>
        body {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            scroll-behavior: smooth;
        }

        /* 1. Hero Text Fade-In + Slide-Up on Load */
        @keyframes fadeSlideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .animate-fade-slide-up {
            opacity: 0;
            animation: fadeSlideUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        /* 2. Hero Mockup Float Up-Down Infinite */
        @keyframes float {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-12px);
            }
        }
        .animate-float {
            animation: float 4s ease-in-out infinite;
        }

        /* 3. CTA Background Pulse */
        @keyframes bgPulse {
            0%, 100% {
                background-color: #1e3a8a; /* Blue 900 */
            }
            50% {
                background-color: #312e81; /* Indigo 900 */
            }
        }
        .animate-bg-pulse {
            animation: bgPulse 8s ease-in-out infinite;
        }

        /* 4. Intersection Observer Scroll Reveal Base Styles */
        .reveal-element {
            opacity: 0;
            transform: translateY(24px);
            transition: opacity 0.7s cubic-bezier(0.16, 1, 0.3, 1), transform 0.7s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .reveal-element.reveal-left {
            transform: translateX(-40px);
        }
        .reveal-element.reveal-right {
            transform: translateX(40px);
        }
        .reveal-element.animate-in {
            opacity: 1;
            transform: translate(0) !important;
        }

        /* Timeline animated progress line */
        @keyframes lineProgress {
            from { width: 0%; }
            to { width: 100%; }
        }
        .animate-line-progress {
            animation: lineProgress 2s cubic-bezier(0.4, 0, 0.2, 1) forwards;
        }

        /* Custom Magnetic Cursor Styles */
        @media (min-width: 768px) {
            body, a, button, select, input, textarea, [role="button"] {
                cursor: none !important;
            }
        }
        
        #custom-cursor {
            position: fixed;
            top: 0;
            left: 0;
            width: 20px;
            height: 20px;
            background-color: #fff;
            border-radius: 50%;
            pointer-events: none;
            z-index: 999999;
            mix-blend-mode: difference;
            transform: translate(-50%, -50%);
            will-change: transform, width, height;
            display: none;
        }
        
        @media (min-width: 768px) {
            #custom-cursor {
                display: block;
            }
        }
    </style>
</head>
<body class="bg-[#F9FAFB] text-slate-900 antialiased overflow-x-hidden">

    <!-- Custom Magnetic Cursor -->
    <div id="custom-cursor"></div>

    <!-- 1. NAVBAR -->
    <nav x-data="{ isScrolled: false }" 
         @scroll.window="isScrolled = (window.pageYOffset > 20)" 
         :class="isScrolled ? 'backdrop-blur-md bg-white/95 border-b border-slate-200/80 shadow-sm py-4' : 'bg-transparent py-6'" 
         class="fixed top-0 inset-x-0 z-50 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between">
                <!-- Logo & BS Icon -->
                <a href="{{ url('/') }}" class="flex items-center gap-2.5 group">
                    <div class="w-10 h-10 bg-blue-600 rounded-xl text-white font-extrabold flex items-center justify-center shadow-md shadow-blue-500/10 group-hover:rotate-12 transition-transform duration-300">
                        BS
                    </div>
                    <div class="flex flex-col text-left leading-none">
                        <span class="text-sm font-black tracking-wide text-slate-900 uppercase">BENGKEL</span>
                        <span class="text-xs font-bold tracking-wider text-blue-600 uppercase">SERVIS</span>
                    </div>
                </a>

                <!-- Middle Menu Navigation Links -->
                <div class="hidden md:flex items-center gap-8 text-sm font-semibold text-slate-600">
                    <a href="#" class="hover:text-blue-600 transition-colors">Beranda</a>
                    <a href="#fitur" class="hover:text-blue-600 transition-colors">Fitur</a>
                    <a href="#alur" class="hover:text-blue-600 transition-colors">Cara Kerja</a>
                    <a href="#testimoni" class="hover:text-blue-600 transition-colors">Testimoni</a>
                </div>

                <!-- Right Action Buttons -->
                <div class="flex items-center gap-4">
                    @auth
                        <a href="{{ route('dashboard') }}" 
                           class="px-5 py-2.5 bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold rounded-full transition-all shadow-md">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="text-slate-600 hover:text-blue-600 text-sm font-semibold transition-colors">
                            Login
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" 
                               class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-full shadow-lg shadow-blue-500/10 transition-all">
                                Daftar Sekarang
                            </a>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- 2. HERO SECTION -->
    <section class="relative pt-32 pb-20 sm:pt-40 sm:pb-28 overflow-hidden bg-gradient-to-b from-blue-50/40 via-white to-transparent">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col items-center justify-center text-center">
                
                <!-- Hero Content (Text & CTAs) -->
                <div class="max-w-3xl mx-auto space-y-8 animate-fade-slide-up text-center z-10" style="animation-delay: 0.1s;">
                    <div class="inline-flex items-center gap-1.5 px-3.5 py-1.5 bg-blue-50 border border-blue-100 rounded-full">
                        <span class="w-2 h-2 rounded-full bg-blue-600 animate-pulse"></span>
                        <span class="text-xs font-semibold text-blue-700 uppercase tracking-wider">Sistem Kelas Dunia</span>
                    </div>
                    
                    <h1 class="text-4xl sm:text-6xl font-black text-slate-950 tracking-tight leading-[1.08]">
                        Servis Elektronik Jadi Lebih <span class="text-blue-600">Mudah & Transparan</span>
                    </h1>
                    
                    <p class="text-lg text-slate-600 max-w-xl mx-auto leading-relaxed">
                        Pantau status perbaikan alat elektronikmu secara real-time. Tidak perlu bolak-balik ke bengkel.
                    </p>
                    
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" 
                               class="px-8 py-4 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-full text-center shadow-lg shadow-blue-500/20 transition-all hover:-translate-y-0.5">
                                Coba Gratis
                            </a>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- 4. FITUR SECTION -->
    <section id="fitur" class="py-20 sm:py-28 bg-[#F9FAFB] relative z-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-16">
            
            <!-- Section Header -->
            <div class="text-center space-y-3">
                <span class="text-xs font-bold text-teal-700 uppercase tracking-widest bg-teal-50 border border-teal-200/50 px-3 py-1 rounded-full">
                    Keunggulan Layanan
                </span>
                <h2 class="text-3xl sm:text-4xl font-black text-slate-950 tracking-tight">
                    Semua yang Kamu Butuhkan
                </h2>
                <p class="text-sm sm:text-base text-slate-500 max-w-md mx-auto">
                    Kemudahan memantau perbaikan dengan antarmuka modern dan pemberitahuan instan.
                </p>
            </div>

            <!-- Features Cards Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-8 max-w-4xl mx-auto">
                
                <!-- Card 1 -->
                <div class="reveal-element bg-white p-8 rounded-3xl border border-slate-200/60 shadow-sm hover:shadow-lg hover:border-blue-500/40 hover:-translate-y-1 transition-all duration-300 space-y-4"
                     style="transition-delay: 0.1s;">
                    <div class="w-12 h-12 bg-blue-50 rounded-2xl text-blue-600 flex items-center justify-center">
                        <!-- Heroicons arrow-path (refresh) inline SVG -->
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900">Tracking Status Real-Time</h3>
                    <p class="text-sm text-slate-500 leading-relaxed">
                        Lacak kemajuan perbaikan perangkat elektronik Anda secara langsung dari detik ke detik tanpa perlu menghubungi gerai.
                    </p>
                </div>

                <!-- Card 2 -->
                <div class="reveal-element bg-white p-8 rounded-3xl border border-slate-200/60 shadow-sm hover:shadow-lg hover:border-blue-500/40 hover:-translate-y-1 transition-all duration-300 space-y-4"
                     style="transition-delay: 0.2s;">
                    <div class="w-12 h-12 bg-blue-50 rounded-2xl text-blue-600 flex items-center justify-center">
                        <!-- Heroicons document-text (receipt) inline SVG -->
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900">Estimasi Biaya Transparan</h3>
                    <p class="text-sm text-slate-500 leading-relaxed">
                        Menghindari kejutan tagihan. Anda akan mendapatkan detail estimasi biaya di awal, lengkap dengan persetujuan digital.
                    </p>
                </div>

                <!-- Card 3 -->
                <div class="reveal-element bg-white p-8 rounded-3xl border border-slate-200/60 shadow-sm hover:shadow-lg hover:border-blue-500/40 hover:-translate-y-1 transition-all duration-300 space-y-4"
                     style="transition-delay: 0.3s;">
                    <div class="w-12 h-12 bg-blue-50 rounded-2xl text-blue-600 flex items-center justify-center">
                        <!-- Heroicons clock (history) inline SVG -->
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900">Riwayat Servis Lengkap</h3>
                    <p class="text-sm text-slate-500 leading-relaxed">
                        Simpan seluruh data rekam jejak servis perangkat Anda demi keperluan garansi atau penjualan perangkat di masa depan.
                    </p>
                </div>

                <!-- Card 4 -->
                <div class="reveal-element bg-white p-8 rounded-3xl border border-slate-200/60 shadow-sm hover:shadow-lg hover:border-blue-500/40 hover:-translate-y-1 transition-all duration-300 space-y-4"
                     style="transition-delay: 0.4s;">
                    <div class="w-12 h-12 bg-blue-50 rounded-2xl text-blue-600 flex items-center justify-center">
                        <!-- Heroicons cog-6-tooth (tool/management) inline SVG -->
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.43l-1.003.828c-.293.241-.438.613-.43.992a7.723 7.723 0 010 .255c-.008.378.137.75.43.991l1.004.827c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.47 6.47 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.281c-.09.543-.56.94-1.11.94h-2.594c-.55 0-1.019-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.43l1.004-.827c.292-.24.437-.613.43-.991a6.932 6.932 0 010-.255c.007-.38-.138-.751-.43-.992l-1.004-.827a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.086.22-.128.332-.183.582-.495.644-.869l.214-1.28Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0Z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900">Manajemen Spare Part</h3>
                    <p class="text-sm text-slate-500 leading-relaxed">
                        Pantau ketersediaan komponen pengganti asli untuk meramalkan estimasi waktu selesai pengerjaan secara akurat.
                    </p>
                </div>

            </div>
        </div>
    </section>

    <!-- 5. CARA KERJA SECTION -->
    <section id="alur" class="py-20 sm:py-28 bg-white border-y border-slate-200/60 relative z-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-16">
            
            <!-- Section Header -->
            <div class="text-center space-y-3">
                <span class="text-xs font-bold text-teal-700 uppercase tracking-widest bg-teal-50 border border-teal-200/50 px-3 py-1 rounded-full">
                    Langkah Mudah
                </span>
                <h2 class="text-3xl sm:text-4xl font-black text-slate-950 tracking-tight">
                    Cara Kerja BENGKEL SERVIS
                </h2>
                <p class="text-sm sm:text-base text-slate-500 max-w-md mx-auto">
                    Alur sederhana perbaikan perangkat dari penyerahan hingga serah terima unit.
                </p>
            </div>

            <!-- Stepper Timeline Grid -->
            <div class="relative pt-6" x-data="{ revealed: false }" x-init="
                let observer = new IntersectionObserver((entries) => {
                    if (entries[0].isIntersecting) { revealed = true; observer.disconnect(); }
                });
                observer.observe($el);
            ">
                <!-- Animated Progress Line Background (Desktop) -->
                <div class="hidden md:block absolute top-14 left-16 right-16 h-1 bg-slate-100 rounded-full z-0 overflow-hidden">
                    <div class="h-full bg-blue-600 rounded-full" :class="revealed ? 'animate-line-progress' : 'w-0'"></div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-4 gap-12 md:gap-8 relative z-10">
                    <!-- Step 1 -->
                    <div class="reveal-element flex md:flex-col items-center md:text-center gap-4 transition-all duration-700" 
                         :class="revealed ? 'animate-in' : ''" style="transition-delay: 0.1s;">
                        <div class="w-16 h-16 rounded-full bg-blue-50 text-blue-600 font-extrabold flex items-center justify-center shrink-0 shadow-md ring-8 ring-white">
                            01
                        </div>
                        <div class="space-y-1">
                            <h4 class="text-base font-bold text-slate-900">Daftar &amp; Order</h4>
                            <p class="text-xs text-slate-500 max-w-[200px] md:mx-auto">
                                Pelanggan mendaftarkan keluhan perangkat elektronik secara daring.
                            </p>
                        </div>
                    </div>

                    <!-- Step 2 -->
                    <div class="reveal-element flex md:flex-col items-center md:text-center gap-4 transition-all duration-700" 
                         :class="revealed ? 'animate-in' : ''" style="transition-delay: 0.4s;">
                        <div class="w-16 h-16 rounded-full bg-blue-50 text-blue-600 font-extrabold flex items-center justify-center shrink-0 shadow-md ring-8 ring-white">
                            02
                        </div>
                        <div class="space-y-1">
                            <h4 class="text-base font-bold text-slate-900">Pemeriksaan &amp; Diagnosa</h4>
                            <p class="text-xs text-slate-500 max-w-[200px] md:mx-auto">
                                Teknisi menerima perangkat dan melakukan analisis kerusakan teknis.
                            </p>
                        </div>
                    </div>

                    <!-- Step 3 -->
                    <div class="reveal-element flex md:flex-col items-center md:text-center gap-4 transition-all duration-700" 
                         :class="revealed ? 'animate-in' : ''" style="transition-delay: 0.7s;">
                        <div class="w-16 h-16 rounded-full bg-blue-50 text-blue-600 font-extrabold flex items-center justify-center shrink-0 shadow-md ring-8 ring-white">
                            03
                        </div>
                        <div class="space-y-1">
                            <h4 class="text-base font-bold text-slate-900">Persetujuan Biaya</h4>
                            <p class="text-xs text-slate-500 max-w-[200px] md:mx-auto">
                                Pelanggan meninjau rincian biaya perbaikan dan memberikan persetujuan.
                            </p>
                        </div>
                    </div>

                    <!-- Step 4 -->
                    <div class="reveal-element flex md:flex-col items-center md:text-center gap-4 transition-all duration-700" 
                         :class="revealed ? 'animate-in' : ''" style="transition-delay: 1s;">
                        <div class="w-16 h-16 rounded-full bg-blue-600 text-white font-extrabold flex items-center justify-center shrink-0 shadow-md ring-8 ring-white">
                            04
                        </div>
                        <div class="space-y-1">
                            <h4 class="text-base font-bold text-slate-900">Servis Selesai</h4>
                            <p class="text-xs text-slate-500 max-w-[200px] md:mx-auto">
                                Perangkat siap diambil dan garansi servis resmi diterbitkan.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- 6. TESTIMONI SECTION -->
    <section id="testimoni" class="py-20 sm:py-28 bg-[#F9FAFB] relative z-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-16">
            
            <!-- Section Header -->
            <div class="text-center space-y-3">
                <span class="text-xs font-bold text-teal-700 uppercase tracking-widest bg-teal-50 border border-teal-200/50 px-3 py-1 rounded-full">
                    Ulasan Pelanggan
                </span>
                <h2 class="text-3xl sm:text-4xl font-black text-slate-950 tracking-tight">
                    Kata Mereka
                </h2>
                <p class="text-sm sm:text-base text-slate-500 max-w-md mx-auto">
                    Kisah sukses dari pelanggan dan pemilik gerai bengkel yang mempercayakan platform kami.
                </p>
            </div>

            <!-- Testimonials Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <!-- Testimonial 1 (Reveal Left) -->
                <div class="reveal-element reveal-left bg-white p-8 rounded-3xl border border-slate-200/60 shadow-sm space-y-6 flex flex-col justify-between hover:shadow-md transition-shadow duration-300">
                    <p class="text-sm text-slate-600 italic leading-relaxed">
                        "Sistem pelacakan real-time dari BENGKEL SERVIS sangat membantu saya. Tidak perlu lagi bolak-balik menanyakan kapan HP saya selesai. Notifikasi WhatsApp juga instan!"
                    </p>
                    <div class="flex items-center gap-4 pt-4 border-t border-slate-100">
                        <div class="w-10 h-10 rounded-full bg-blue-600 text-white font-extrabold flex items-center justify-center text-sm shrink-0">
                            RA
                        </div>
                        <div>
                            <h5 class="text-sm font-bold text-slate-900">Raisul Akram</h5>
                            <p class="text-xs text-slate-500">Pelanggan - Jakarta</p>
                            <!-- Star rating -->
                            <div class="flex text-amber-400 gap-0.5 mt-1">
                                @for($i=0; $i<5; $i++)
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3.5 h-3.5"><path fill-rule="evenodd" d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.6 3.102-1.196 4.657c-.21.819.674 1.46 1.368 1.01l4.15-2.701 4.15 2.701c.694.45 1.578-.191 1.368-1.01l-1.196-4.657 3.6-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401z" clip-rule="evenodd" /></svg>
                                @endfor
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 2 (Reveal Standard) -->
                <div class="reveal-element bg-white p-8 rounded-3xl border border-slate-200/60 shadow-sm space-y-6 flex flex-col justify-between hover:shadow-md transition-shadow duration-300">
                    <p class="text-sm text-slate-600 italic leading-relaxed">
                        "Sejak menggunakan BENGKEL SERVIS untuk mengelola bengkel servis komputer saya, kepuasan pelanggan naik drastis. Penjadwalan teknisi teratur dan pembukuan menjadi rapi."
                    </p>
                    <div class="flex items-center gap-4 pt-4 border-t border-slate-100">
                        <div class="w-10 h-10 rounded-full bg-teal-600 text-white font-extrabold flex items-center justify-center text-sm shrink-0">
                            WS
                        </div>
                        <div>
                            <h5 class="text-sm font-bold text-slate-900">Wenny Sasmita</h5>
                            <p class="text-xs text-slate-500">Pemilik Bengkel - Bandung</p>
                            <!-- Star rating -->
                            <div class="flex text-amber-400 gap-0.5 mt-1">
                                @for($i=0; $i<5; $i++)
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3.5 h-3.5"><path fill-rule="evenodd" d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.6 3.102-1.196 4.657c-.21.819.674 1.46 1.368 1.01l4.15-2.701 4.15 2.701c.694.45 1.578-.191 1.368-1.01l-1.196-4.657 3.6-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401z" clip-rule="evenodd" /></svg>
                                @endfor
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 3 (Reveal Right) -->
                <div class="reveal-element reveal-right bg-white p-8 rounded-3xl border border-slate-200/60 shadow-sm space-y-6 flex flex-col justify-between hover:shadow-md transition-shadow duration-300">
                    <p class="text-sm text-slate-600 italic leading-relaxed">
                        "Sangat menyukai fitur persetujuan biaya digital. Saya bisa menyetujui atau menolak tawaran tindakan penggantian suku cadang sebelum teknisi mulai melakukan pengerjaan."
                    </p>
                    <div class="flex items-center gap-4 pt-4 border-t border-slate-100">
                        <div class="w-10 h-10 rounded-full bg-indigo-600 text-white font-extrabold flex items-center justify-center text-sm shrink-0">
                            AH
                        </div>
                        <div>
                            <h5 class="text-sm font-bold text-slate-900">Aris Hidayat</h5>
                            <p class="text-xs text-slate-500">Pelanggan - Surabaya</p>
                            <!-- Star rating -->
                            <div class="flex text-amber-400 gap-0.5 mt-1">
                                @for($i=0; $i<5; $i++)
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3.5 h-3.5"><path fill-rule="evenodd" d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.6 3.102-1.196 4.657c-.21.819.674 1.46 1.368 1.01l4.15-2.701 4.15 2.701c.694.45 1.578-.191 1.368-1.01l-1.196-4.657 3.6-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401z" clip-rule="evenodd" /></svg>
                                @endfor
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- 7. CTA SECTION -->
    <section class="py-20 sm:py-28 relative overflow-hidden bg-blue-900 animate-bg-pulse text-white">
        <!-- Floating circular blur ring -->
        <div class="absolute -top-12 -left-12 w-80 h-80 bg-white/5 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-12 -right-12 w-96 h-96 bg-blue-400/10 rounded-full blur-3xl"></div>
        
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10 space-y-8">
            <h2 class="text-3xl sm:text-5xl font-extrabold tracking-tight leading-tight">
                Siap Mulai Kelola Bengkelmu?
            </h2>
            <p class="text-base sm:text-lg text-blue-100 max-w-xl mx-auto leading-relaxed">
                Tingkatkan transparansi perbaikan dan kepuasan pelanggan dengan sistem pelacakan tiket digital modern sekarang juga.
            </p>
            <div class="pt-4">
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" 
                       class="inline-block px-8 py-4 bg-white hover:bg-slate-50 text-blue-900 font-bold rounded-full shadow-2xl transition-all hover:scale-105">
                        Daftar Gratis Sekarang
                    </a>
                @endif
            </div>
        </div>
    </section>

    <!-- 8. FOOTER -->
    <footer class="bg-slate-900 text-slate-400 pt-16 pb-12 shrink-0 border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
            
            <div class="grid grid-cols-1 md:grid-cols-5 gap-8">
                <!-- Brand Info Column -->
                <div class="md:col-span-2 space-y-4">
                    <div class="flex items-center gap-2.5">
                        <div class="w-10 h-10 bg-blue-600 rounded-xl text-white font-extrabold flex items-center justify-center shadow-md shadow-blue-500/10">
                            BS
                        </div>
                        <div class="flex flex-col text-left leading-none">
                            <span class="text-sm font-black tracking-wide text-white uppercase">BENGKEL</span>
                            <span class="text-xs font-bold tracking-wider text-blue-500 uppercase">SERVIS</span>
                        </div>
                    </div>
                    <p class="text-sm text-slate-500 leading-relaxed max-w-xs">
                        Platform manajemen servis elektronik modern untuk mempercepat proses perbaikan dan transparansi status perbaikan pelanggan.
                    </p>
                </div>

                <!-- Product Links -->
                <div class="space-y-3 text-sm">
                    <h5 class="font-bold text-white uppercase tracking-wider text-xs">Produk</h5>
                    <ul class="space-y-2">
                        <li><a href="#" class="hover:text-white transition-colors">Pelacakan Tiket</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Notifikasi WhatsApp</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Harga Paket</a></li>
                    </ul>
                </div>

                <!-- Company Links -->
                <div class="space-y-3 text-sm">
                    <h5 class="font-bold text-white uppercase tracking-wider text-xs">Perusahaan</h5>
                    <ul class="space-y-2">
                        <li><a href="#" class="hover:text-white transition-colors">Tentang Kami</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Karir</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Mitra Teknisi</a></li>
                    </ul>
                </div>

                <!-- Support Links -->
                <div class="space-y-3 text-sm">
                    <h5 class="font-bold text-white uppercase tracking-wider text-xs">Bantuan</h5>
                    <ul class="space-y-2">
                        <li><a href="#" class="hover:text-white transition-colors">Pusat Bantuan</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Hubungi Kami</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Syarat &amp; Ketentuan</a></li>
                    </ul>
                </div>
            </div>

            <!-- Divider & Copyright -->
            <div class="pt-8 border-t border-slate-800 flex flex-col sm:flex-row justify-between items-center gap-4 text-xs text-slate-650">
                <p>&copy; {{ date('Y') }} BENGKEL SERVIS. Hak Cipta Dilindungi Undang-Undang.</p>
                <div class="flex gap-4">
                    <!-- Social icons (Heroicons-style placeholders) -->
                    <a href="#" class="hover:text-white transition-colors">
                        <span class="sr-only">Twitter</span>
                        <svg fill="currentColor" viewBox="0 0 24 24" class="w-5 h-5"><path d="M13.682 10.62L22.25 1h-2.03l-7.44 8.528L6.82 1H0l9.006 12.91L0 23h2.03l7.98-9.133L15.65 23H22.5l-8.818-12.38zm-2.775 3.176l-.91-.128-7.228-1.02H5.16l4.9 6.896.91.127 7.585 1.07h2.38l-5.463-7.674z"/></svg>
                    </a>
                    <a href="#" class="hover:text-white transition-colors">
                        <span class="sr-only">GitHub</span>
                        <svg fill="currentColor" viewBox="0 0 24 24" class="w-5 h-5"><path fill-rule="evenodd" clip-rule="evenodd" d="M12 2C6.477 2 2 6.477 2 12c0 4.42 2.865 8.166 6.839 9.489.5.092.682-.217.682-.482 0-.237-.008-.866-.013-1.7-2.782.603-3.369-1.34-3.369-1.34-.454-1.156-1.11-1.464-1.11-1.464-.908-.62.069-.608.069-.608 1.003.07 1.531 1.03 1.531 1.03.892 1.529 2.341 1.087 2.91.831.092-.646.35-1.086.636-1.336-2.22-.253-4.555-1.11-4.555-4.943 0-1.091.39-1.984 1.029-2.683-.103-.253-.446-1.27.098-2.647 0 0 .84-.269 2.75 1.025A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.294 2.747-1.025 2.747-1.025.546 1.377.203 2.394.1 2.647.64.699 1.028 1.592 1.028 2.683 0 3.842-2.339 4.687-4.566 4.935.359.309.678.919.678 1.852 0 1.336-.012 2.415-.012 2.743 0 .267.18.578.688.48C19.137 20.162 22 16.418 22 12c0-5.523-4.477-10-10-10z"/></svg>
                    </a>
                </div>
            </div>
            
        </div>
    </footer>

    <!-- Intersection Observer Script for Scroll Reveals -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const revealElements = document.querySelectorAll('.reveal-element');
            
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('animate-in');
                        // Stop observing once animated
                        observer.unobserve(entry.target);
                    }
                });
            }, {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            });

            revealElements.forEach(el => observer.observe(el));
        });
    </script>

    <!-- GSAP Animated Magnetic Cursor Script -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Defensive check if GSAP loaded successfully and only run on desktop
            if (typeof gsap === 'undefined' || window.innerWidth < 768) return;

            const cursor = document.getElementById('custom-cursor');
            if (!cursor) return;

            // Set initial state
            gsap.set(cursor, { xPercent: -50, yPercent: -50, x: -100, y: -100 });

            // GSAP quickTo for ultra-smooth cursor movement
            const xTo = gsap.quickTo(cursor, "x", { duration: 0.35, ease: "power3.out" });
            const yTo = gsap.quickTo(cursor, "y", { duration: 0.35, ease: "power3.out" });

            let isMagnetic = false;
            let targetBounds = null;

            // Follow mouse movement
            window.addEventListener('mousemove', (e) => {
                // Ensure kursor terlihat saat mulai bergerak
                if (cursor.style.display === 'none' || cursor.style.opacity === '0') {
                    gsap.set(cursor, { display: 'block', opacity: 1 });
                }

                if (isMagnetic && targetBounds) {
                    // Center coordinates of the hovered target
                    const targetCenterX = targetBounds.left + targetBounds.width / 2;
                    const targetCenterY = targetBounds.top + targetBounds.height / 2;

                    // Magnet pull: 70% towards center, 30% responsive to exact mouse cursor position
                    const x = targetCenterX + (e.clientX - targetCenterX) * 0.3;
                    const y = targetCenterY + (e.clientY - targetCenterY) * 0.3;

                    xTo(x);
                    yTo(y);
                } else {
                    xTo(e.clientX);
                    yTo(e.clientY);
                }
            });

            // Hide custom cursor when leaving page window
            document.addEventListener('mouseleave', () => {
                gsap.to(cursor, { opacity: 0, duration: 0.2 });
            });

            document.addEventListener('mouseenter', () => {
                gsap.to(cursor, { opacity: 1, duration: 0.2 });
            });

            // Function to register hover handlers on magnetic targets
            function attachMagnetic(el) {
                if (el.dataset.magneticAttached) return;
                el.dataset.magneticAttached = "true";

                el.addEventListener('mouseenter', () => {
                    isMagnetic = true;
                    targetBounds = el.getBoundingClientRect();

                    // Custom cursor scales up on hover
                    gsap.to(cursor, {
                        width: 48,
                        height: 48,
                        duration: 0.3,
                        ease: "power2.out"
                    });
                });

                el.addEventListener('mousemove', () => {
                    targetBounds = el.getBoundingClientRect();
                });

                el.addEventListener('mouseleave', () => {
                    isMagnetic = false;
                    targetBounds = null;

                    // Revert custom cursor size
                    gsap.to(cursor, {
                        width: 20,
                        height: 20,
                        duration: 0.3,
                        ease: "power2.out"
                    });
                });
            }

            // Initialize all existing interactive elements
            function initMagneticElements() {
                const elements = document.querySelectorAll('a, button, [role="button"], input[type="submit"], input[type="button"]');
                elements.forEach(attachMagnetic);
            }

            initMagneticElements();

            // DOM MutationObserver to auto-apply magnetic behavior to dynamic elements globally
            const domObserver = new MutationObserver((mutations) => {
                mutations.forEach(mutation => {
                    mutation.addedNodes.forEach(node => {
                        if (node.nodeType === Node.ELEMENT_NODE) {
                            if (node.matches('a, button, [role="button"], input[type="submit"], input[type="button"]')) {
                                attachMagnetic(node);
                            }
                            node.querySelectorAll('a, button, [role="button"], input[type="submit"], input[type="button"]').forEach(attachMagnetic);
                        }
                    });
                });
            });

            domObserver.observe(document.body, { childList: true, subtree: true });
        });
    </script>

</body>
</html>
