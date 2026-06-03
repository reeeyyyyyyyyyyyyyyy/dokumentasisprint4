<!DOCTYPE html>
<html lang="id" x-data="{ temaGelap: localStorage.getItem('temaGelap') === 'true' }"
    x-init="$watch('temaGelap', val => localStorage.setItem('temaGelap', val))" :class="{ 'dark': temaGelap }">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Lacak Laporan - SIGAP BDG</title>
    <meta name="description" content="Lacak status laporan infrastruktur Anda menggunakan Tracking ID yang diberikan saat laporan dibuat.">

    <meta name="theme-color" content="#f97316">
    <link rel="apple-touch-icon" href="https://ui-avatars.com/api/?name=SIGAP+BDG&background=f97316&color=fff&size=180">
    <link rel="shortcut icon" href="https://ui-avatars.com/api/?name=SB&background=f97316&color=fff&size=32">

    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Outfit', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            50: '#fff7ed',
                            100: '#ffedd5',
                            200: '#fed7aa',
                            300: '#fdba74',
                            400: '#fb923c',
                            500: '#f97316',
                            600: '#ea580c',
                            700: '#c2410c',
                            800: '#9a3412',
                            900: '#7c2d12',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        body {
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        html {
            scroll-behavior: smooth;
        }

        .gradient-text {
            background: linear-gradient(135deg, #fb923c, #f97316);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hasil-masuk {
            animation: masuk 0.4s ease forwards;
        }

        @keyframes masuk {
            from {
                opacity: 0;
                transform: translateY(16px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }

        .dark .glass-card {
            background: rgba(30, 41, 59, 0.7);
        }
    </style>
</head>

<body class="bg-stone-50 dark:bg-slate-950 text-stone-800 dark:text-slate-100 transition-colors duration-300 min-h-screen flex flex-col">

    <nav class="bg-white/80 dark:bg-slate-900/80 backdrop-blur-md sticky top-0 z-40 shadow-sm border-b border-stone-100 dark:border-slate-800">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <a href="{{ route('beranda') }}" class="flex items-center gap-2">
                    <div class="w-8 h-8 bg-brand-500 rounded-lg flex items-center justify-center shadow-md shadow-brand-500/30">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <span class="font-bold text-xl tracking-tight text-stone-900 dark:text-white">SIGAP<span class="text-brand-500">BDG</span></span>
                </a>

                <div class="flex items-center gap-3">
                    <button @click="temaGelap = !temaGelap"
                        class="flex items-center justify-center w-10 h-10 rounded-full bg-stone-100 dark:bg-slate-800 text-stone-500 dark:text-slate-400 hover:text-brand-500 transition">
                        <span x-show="!temaGelap">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                            </svg>
                        </span>
                        <span x-show="temaGelap">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707M17.657 17.657l-.707-.707M6.343 6.343l-.707-.707M12 8a4 4 0 100 8 4 4 0 000-8z" />
                            </svg>
                        </span>
                    </button>

                    <a href="{{ route('lapor') }}"
                        class="bg-brand-500 hover:bg-brand-600 text-white text-sm font-semibold px-5 py-2.5 rounded-full transition shadow-md shadow-brand-500/20 flex items-center gap-1.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Buat Laporan
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <main class="flex-1 w-full max-w-2xl mx-auto px-4 sm:px-6 pt-12 pb-20">

        <div class="mb-10">
            <div
                class="inline-flex items-center gap-2 bg-brand-100 dark:bg-brand-500/10 border border-brand-200 dark:border-brand-500/20 text-brand-600 dark:text-brand-300 text-xs font-semibold px-3 py-1.5 rounded-full mb-4">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                Lacak Status
            </div>
            <h1 class="text-4xl md:text-5xl font-extrabold text-stone-900 dark:text-white leading-tight mb-3">
                Cek Status <span class="gradient-text">Laporan</span>
            </h1>
            <p class="text-stone-500 dark:text-slate-400 text-base leading-relaxed">
                Masukkan Tracking ID yang kamu terima saat laporan dikirim untuk melihat perkembangan terbaru.
            </p>
        </div>

        <form action="{{ route('proses.lacak') }}" method="POST"
            class="glass-card bg-white/70 dark:bg-slate-800/70 backdrop-blur-md border border-white/40 dark:border-slate-700/50 rounded-3xl p-5 sm:p-6 mb-8 shadow-xl">
            @csrf
            <label for="inputTrackingId" class="block text-sm font-semibold text-stone-800 dark:text-white mb-1">Tracking ID</label>
            <p class="text-xs text-stone-400 dark:text-slate-500 mb-4">Contoh format: <span
                    class="text-brand-500 font-mono font-semibold">SIGAP-A1B2C3</span></p>
            <div class="flex gap-3">
                <input
                    type="text"
                    id="inputTrackingId"
                    name="tracking_id"
                    value="{{ $kodeLacak ?? old('tracking_id', request('tracking_id')) }}"
                    placeholder="SIGAP-XXXXXX"
                    class="flex-1 bg-stone-50 dark:bg-slate-900 border border-stone-200 dark:border-slate-600 text-stone-800 dark:text-white placeholder-stone-400 dark:placeholder-slate-600 rounded-2xl px-4 py-3 text-sm font-mono uppercase focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent transition"
                    autocomplete="off"
                    spellcheck="false"
                >
                <button type="submit"
                    class="bg-brand-500 hover:bg-brand-600 text-white font-bold px-6 py-3 rounded-2xl shadow-lg shadow-brand-500/20 flex items-center gap-2 whitespace-nowrap transition-all duration-300 hover:-translate-y-0.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    Cari
                </button>
            </div>
            @error('tracking_id')
                <div class="mt-3 text-red-500 dark:text-red-400 text-xs flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    {{ $message }}
                </div>
            @enderror
        </form>

        @isset($kodeLacak)
            @if($dataLaporan)
            <div class="hasil-masuk space-y-5">

                <div class="glass-card bg-white/70 dark:bg-slate-800/70 backdrop-blur-md border border-white/40 dark:border-slate-700/50 rounded-3xl overflow-hidden shadow-xl">
                    <div class="px-5 sm:px-6 pt-5 pb-4 border-b border-stone-100 dark:border-slate-700/50 flex items-center justify-between">
                        <div>
                            <div class="text-xs text-stone-400 dark:text-slate-500 mb-1">Nomor Laporan</div>
                            <div class="text-xl font-black tracking-widest text-stone-800 dark:text-white font-mono">{{ $dataLaporan->tracking_id }}</div>
                        </div>
                        @php
                            $isSpam = $dataLaporan->analisisAi?->is_spam ?? false;
                            $warnaStatus = match($dataLaporan->status) {
                                'Menunggu' => ['bg' => 'bg-amber-100 dark:bg-yellow-500/10', 'border' => 'border-amber-200 dark:border-yellow-500/20', 'text' => 'text-amber-700 dark:text-yellow-400', 'dot' => 'bg-amber-400', 'pulse' => true],
                                'Proses'   => ['bg' => 'bg-brand-100 dark:bg-brand-500/10',   'border' => 'border-brand-200 dark:border-brand-500/20',   'text' => 'text-brand-700 dark:text-brand-400',   'dot' => 'bg-brand-500', 'pulse' => false],
                                'Selesai'  => ['bg' => 'bg-emerald-100 dark:bg-green-500/10',  'border' => 'border-emerald-200 dark:border-green-500/20',  'text' => 'text-emerald-700 dark:text-green-400',  'dot' => 'bg-emerald-500', 'pulse' => false],
                                'Ditolak'  => ['bg' => 'bg-red-100 dark:bg-red-500/10',     'border' => 'border-red-200 dark:border-red-500/20',     'text' => 'text-red-700 dark:text-red-400',     'dot' => 'bg-red-500',   'pulse' => false],
                                default    => ['bg' => 'bg-stone-100 dark:bg-slate-700',      'border' => 'border-stone-200 dark:border-slate-600',      'text' => 'text-stone-500 dark:text-slate-400',   'dot' => 'bg-stone-400', 'pulse' => false],
                            };
                        @endphp
                        <span class="inline-flex items-center gap-1.5 {{ $warnaStatus['bg'] }} border {{ $warnaStatus['border'] }} {{ $warnaStatus['text'] }} text-xs font-bold px-3 py-1.5 rounded-full">
                            <span class="w-1.5 h-1.5 rounded-full {{ $warnaStatus['dot'] }} {{ $warnaStatus['pulse'] ? 'animate-pulse' : '' }}"></span>
                            {{ $dataLaporan->status }}
                        </span>
                    </div>

                    @if($isSpam)
                    <div class="mx-5 sm:mx-6 mb-0 mt-1">
                        <div class="bg-red-50 dark:bg-red-950/50 border border-red-200 dark:border-red-500/30 rounded-2xl px-4 py-3.5 flex items-start gap-3">
                            <div class="w-9 h-9 bg-red-100 dark:bg-red-500/20 rounded-xl flex items-center justify-center flex-shrink-0 mt-0.5">
                                <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-2 flex-wrap mb-1">
                                    <span class="text-sm font-bold text-red-700 dark:text-red-400">Terdeteksi AI / SPAM</span>
                                </div>
                                <p class="text-xs text-red-600/80 dark:text-red-400/80 leading-relaxed">
                                    Sistem AI kami mendeteksi bahwa laporan ini kemungkinan besar merupakan konten duplikat, tidak relevan, atau terindikasi spam. Laporan ini <strong>tidak akan diproses</strong>.
                                </p>
                                <p class="text-[11px] text-red-400 dark:text-red-500 mt-1.5">
                                    Jika Anda yakin ini adalah laporan valid, silakan hubungi dinas terkait secara langsung.
                                </p>
                            </div>
                        </div>
                    </div>
                    @endif

                    <div class="px-5 sm:px-6 py-5">
                        @if($dataLaporan->status !== 'Ditolak')
                        <div class="flex gap-2 mb-6">
                            @php
                                $tahapan = ['Menunggu', 'Proses', 'Selesai'];
                                $indeksAktif = array_search($dataLaporan->status, $tahapan);
                            @endphp
                            @foreach($tahapan as $i => $tahap)
                            <div class="flex-1">
                                <div
                                    class="h-1.5 rounded-full {{ $i <= $indeksAktif ? 'bg-gradient-to-r from-brand-400 to-brand-500' : 'bg-stone-200 dark:bg-slate-700' }} mb-2 transition-all">
                                </div>
                                <div
                                    class="text-xs {{ $i <= $indeksAktif ? 'text-stone-600 dark:text-slate-300' : 'text-stone-400 dark:text-slate-600' }} font-medium text-center">
                                    {{ $tahap }}</div>
                            </div>
                            @endforeach
                        </div>
                        @endif

                        <div class="grid grid-cols-2 gap-4 mb-5">
                            <div class="bg-stone-50 dark:bg-slate-900/60 rounded-2xl p-4 border border-stone-100 dark:border-slate-700/50">
                                <div class="text-xs text-stone-400 dark:text-slate-500 mb-1">Dilaporkan pada</div>
                                <div class="text-sm font-semibold text-stone-800 dark:text-white">{{ $dataLaporan->created_at->translatedFormat('d M Y') }}</div>
                                <div class="text-xs text-stone-400 dark:text-slate-500">{{ $dataLaporan->created_at->translatedFormat('H:i') }} WIB</div>
                            </div>
                            <div class="bg-stone-50 dark:bg-slate-900/60 rounded-2xl p-4 border border-stone-100 dark:border-slate-700/50">
                                <div class="text-xs text-stone-400 dark:text-slate-500 mb-1">Koordinat GPS</div>
                                <div class="text-xs font-mono text-brand-500 dark:text-brand-400">{{ $dataLaporan->latitude }}</div>
                                <div class="text-xs font-mono text-brand-500 dark:text-brand-400">{{ $dataLaporan->longitude }}</div>
                            </div>
                        </div>

                        <!-- ========================================================= -->
                        <!-- SPRINT 4 - FEATURE 5: Audit Fisik & Timeline [Dev 5] -->
                        <!-- ========================================================= -->
                        <div class="mb-6 pt-5 border-t border-stone-100 dark:border-slate-700/50">
                            <div class="text-sm font-bold text-stone-800 dark:text-white mb-4 flex items-center gap-2">
                                <svg class="w-5 h-5 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Riwayat Perkembangan Laporan
                            </div>
                            
                            <div class="relative pl-6 border-l-2 border-stone-200 dark:border-slate-800 space-y-6 ml-3">
                                @forelse($dataLaporan->timeline as $tl)
                                    <div class="relative">
                                        <!-- Dot status -->
                                        @php
                                            $colorDot = match($tl->status) {
                                                'Menunggu' => 'bg-amber-500 ring-amber-100 dark:ring-yellow-950/50',
                                                'Proses'   => 'bg-brand-500 ring-brand-100 dark:ring-brand-950/50',
                                                'Selesai'  => 'bg-emerald-500 ring-emerald-100 dark:ring-green-950/50',
                                                'Ditolak'  => 'bg-red-500 ring-red-100 dark:ring-red-950/50',
                                                default    => 'bg-stone-500 ring-stone-100 dark:ring-slate-900',
                                            };
                                        @endphp
                                        <div class="absolute -left-[31px] top-1.5 w-4 h-4 rounded-full {{ $colorDot }} ring-4 z-10"></div>
                                        
                                        <div>
                                            <div class="flex items-center justify-between gap-2 flex-wrap mb-1">
                                                <span class="text-xs font-bold text-stone-700 dark:text-slate-300">
                                                    Status: {{ $tl->status }}
                                                </span>
                                                <span class="text-[10px] text-stone-400 dark:text-slate-500 font-mono">
                                                    {{ $tl->created_at->translatedFormat('d M Y - H:i') }} WIB
                                                </span>
                                            </div>
                                            <p class="text-xs text-stone-500 dark:text-slate-400 leading-relaxed">
                                                {{ $tl->deskripsi }}
                                            </p>
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-xs text-stone-400 dark:text-slate-600 italic">Belum ada riwayat tercatat.</div>
                                @endforelse
                            </div>
                        </div>

                        @if($dataLaporan->foto_selesai)
                            <div class="mb-6 pt-5 border-t border-stone-100 dark:border-slate-700/50">
                                <div class="text-xs text-stone-400 dark:text-slate-500 mb-2.5 font-medium flex items-center justify-between">
                                    <span class="flex items-center gap-1.5">
                                        <svg class="w-4 h-4 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        Perbandingan Foto (Geser Slider)
                                    </span>
                                    <span class="text-[10px] text-stone-400 font-mono">Sebelum vs Sesudah</span>
                                </div>
                                <div class="relative w-full aspect-video rounded-2xl overflow-hidden select-none border border-stone-200 dark:border-slate-700/50 shadow-inner" x-data="{ sliderVal: 50 }">
                                    <!-- Before Image (Background) -->
                                    <img src="{{ asset('storage/' . $dataLaporan->foto_selesai) }}" class="absolute inset-0 w-full h-full object-cover" alt="Sebelum Perbaikan">
                                    <div class="absolute left-4 top-4 bg-black/60 backdrop-blur-sm text-white px-2.5 py-1 text-[10px] font-bold rounded-lg uppercase tracking-wider z-20">
                                        Sebelum
                                    </div>

                                    <!-- After Image (Overlay, clipped from the right side) -->
                                    <img src="{{ asset('storage/' . $dataLaporan->foto_awal) }}" 
                                        class="absolute inset-0 w-full h-full object-cover z-10 pointer-events-none" 
                                        :style="`clip-path: inset(0 ${100 - sliderVal}% 0 0)`"
                                        alt="Setelah Perbaikan">
                                    <div class="absolute right-4 top-4 bg-brand-50 text-black px-2.5 py-1 text-[10px] font-bold rounded-lg uppercase tracking-wider z-20"
                                        :style="`opacity: ${sliderVal > 15 ? 1 : 0}; transition: opacity 0.2s;` shadow-lg">
                                        Sesudah
                                    </div>
                                    
                                    <!-- Slide Handle Line -->
                                    <div class="absolute top-0 bottom-0 w-0.5 bg-white z-20 pointer-events-none shadow" :style="`left: ${sliderVal}%` shadow-lg">
                                        <!-- Slide Handle Button -->
                                        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-8 h-8 rounded-full bg-white text-slate-800 dark:text-slate-900 shadow-xl flex items-center justify-center border border-slate-200 dark:border-slate-700 cursor-ew-resize">
                                            <svg class="w-4 h-4 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 9l-4 3 4 3m8-6l4 3-4 3" />
                                            </svg>
                                        </div>
                                    </div>

                                    <!-- Invisible Range Input overlay to capture drags smoothly -->
                                    <input type="range" min="0" max="100" x-model="sliderVal" class="absolute inset-0 w-full h-full opacity-0 cursor-ew-resize z-30 m-0">
                                </div>
                            </div>
                        @else
                            <div class="mb-6">
                                <div class="text-xs text-stone-400 dark:text-slate-500 mb-2 font-medium">Foto Laporan Awal</div>
                                <div class="rounded-2xl overflow-hidden bg-stone-100 dark:bg-slate-900 aspect-video flex items-center justify-center border border-stone-200 dark:border-slate-700/50">
                                    <img
                                        src="{{ asset('storage/' . $dataLaporan->foto_awal) }}"
                                        alt="Foto kerusakan"
                                        class="w-full h-full object-cover"
                                        onerror="this.parentElement.innerHTML='<div class=\'text-stone-400 dark:text-slate-600 text-sm flex flex-col items-center gap-2\'><svg class=\'w-8 h-8\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'1.5\' d=\'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z\'/></svg>Foto tidak tersedia</div>'"
                                    >
                                </div>
                            </div>
                        @endif
                        <!-- ========================================================= -->

                        @if($dataLaporan->status === 'Selesai')
                            <div class="mt-6 pt-6 border-t border-stone-100 dark:border-slate-700/50">
                                <div class="text-sm font-bold text-stone-800 dark:text-white mb-4 flex items-center gap-2">
                                    <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                    </svg>
                                    Ulasan Penanganan
                                </div>
                                
                                @if(session('sukses_ulasan'))
                                <div class="mb-4 bg-emerald-50 dark:bg-emerald-900/30 border border-emerald-200 dark:border-emerald-700 text-emerald-700 dark:text-emerald-400 px-4 py-3 rounded-2xl text-sm flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    {{ session('sukses_ulasan') }}
                                </div>
                                @endif

                                @if($dataLaporan->ulasanLaporan->count() > 0)
                                    <div class="space-y-3 mb-4 max-h-64 overflow-y-auto pr-1">
                                        @foreach($dataLaporan->ulasanLaporan as $ulasanData)
                                        <div class="bg-stone-50 dark:bg-slate-900/50 p-4 rounded-2xl border border-stone-100 dark:border-slate-700/50">
                                            <div class="flex items-center gap-1 mb-2">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <svg class="w-5 h-5 {{ $i <= $ulasanData->rating ? 'text-amber-400 fill-amber-400' : 'text-stone-300 dark:text-slate-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                                    </svg>
                                                @endfor
                                                <span class="text-xs text-slate-400 ml-auto">{{ $ulasanData->created_at->diffForHumans() }}</span>
                                            </div>
                                            @if($ulasanData->ulasan)
                                                <p class="text-sm text-stone-600 dark:text-slate-300 italic">"{{ $ulasanData->ulasan }}"</p>
                                            @else
                                                <p class="text-sm text-stone-400 dark:text-slate-500 italic">(Tidak ada ulasan tertulis)</p>
                                            @endif
                                        </div>
                                        @endforeach
                                    </div>
                                    <div x-data="{ tampilForm: false }">
                                        <button type="button" @click="tampilForm = !tampilForm" x-show="!tampilForm" class="w-full bg-brand-50 hover:bg-brand-100 text-brand-600 dark:bg-brand-900/20 dark:text-brand-400 dark:hover:bg-brand-900/30 font-semibold text-sm py-2.5 rounded-xl transition border border-brand-200 dark:border-brand-800/50">Tambah Ulasan Lagi</button>
                                        <div x-show="tampilForm" x-transition>
                                            <form action="{{ route('lacak.ulasan', $dataLaporan->id) }}" method="POST" class="bg-stone-50 dark:bg-slate-900/50 p-5 rounded-2xl border border-stone-100 dark:border-slate-700/50 mt-4" x-data="{ rating: 0, hover: 0 }">
                                                @csrf
                                                <div class="mb-4">
                                                    <label class="block text-xs font-semibold text-stone-600 dark:text-slate-400 mb-2">Beri Nilai Penanganan Laporan Ini</label>
                                                    <div class="flex items-center gap-1" @mouseleave="hover = 0">
                                                        <input type="hidden" name="rating" x-model="rating">
                                                        <template x-for="i in 5" :key="i">
                                                            <button type="button" 
                                                                @mouseover="hover = i" 
                                                                @click="rating = i"
                                                                class="focus:outline-none transition-transform hover:scale-110">
                                                                <svg class="w-8 h-8 transition-colors" 
                                                                    :class="(hover >= i || (!hover && rating >= i)) ? 'text-amber-400 fill-amber-400' : 'text-stone-300 dark:text-slate-600'" 
                                                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                                                </svg>
                                                            </button>
                                                        </template>
                                                    </div>
                                                    @error('rating')
                                                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                                <div class="mb-4" x-show="rating > 0" x-transition>
                                                    <label for="ulasan" class="block text-xs font-semibold text-stone-600 dark:text-slate-400 mb-2">Ulasan (Opsional)</label>
                                                    <textarea name="ulasan" id="ulasan" rows="3" placeholder="Tuliskan pengalaman atau saran Anda..."
                                                        class="w-full bg-white dark:bg-slate-800 border border-stone-200 dark:border-slate-700 text-stone-800 dark:text-white rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent transition resize-none"></textarea>
                                                </div>
                                                <div class="flex gap-2">
                                                    <button type="button" @click="tampilForm = false" class="flex-1 bg-slate-200 hover:bg-slate-300 dark:bg-slate-700 dark:hover:bg-slate-600 text-slate-700 dark:text-slate-200 font-bold text-sm py-2.5 rounded-xl transition">
                                                        Batal
                                                    </button>
                                                    <button type="submit" x-show="rating > 0" x-transition
                                                        class="flex-1 bg-amber-500 hover:bg-amber-600 text-white font-bold text-sm py-2.5 rounded-xl transition shadow-md shadow-amber-500/20">
                                                        Kirim Ulasan
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                @else
                                    <!-- Review Form -->
                                    <form action="{{ route('lacak.ulasan', $dataLaporan->id) }}" method="POST" class="bg-stone-50 dark:bg-slate-900/50 p-5 rounded-2xl border border-stone-100 dark:border-slate-700/50" x-data="{ rating: 0, hover: 0 }">
                                        @csrf
                                        <div class="mb-4">
                                            <label class="block text-xs font-semibold text-stone-600 dark:text-slate-400 mb-2">Beri Nilai Penanganan Laporan Ini</label>
                                            <div class="flex items-center gap-1" @mouseleave="hover = 0">
                                                <input type="hidden" name="rating" x-model="rating">
                                                <template x-for="i in 5" :key="i">
                                                    <button type="button" 
                                                        @mouseover="hover = i" 
                                                        @click="rating = i"
                                                        class="focus:outline-none transition-transform hover:scale-110">
                                                        <svg class="w-8 h-8 transition-colors" 
                                                            :class="(hover >= i || (!hover && rating >= i)) ? 'text-amber-400 fill-amber-400' : 'text-stone-300 dark:text-slate-600'" 
                                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                                        </svg>
                                                    </button>
                                                </template>
                                            </div>
                                            @error('rating')
                                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="mb-4" x-show="rating > 0" x-transition>
                                            <label for="ulasan" class="block text-xs font-semibold text-stone-600 dark:text-slate-400 mb-2">Ulasan (Opsional)</label>
                                            <textarea name="ulasan" id="ulasan" rows="3" placeholder="Tuliskan pengalaman atau saran Anda..."
                                                class="w-full bg-white dark:bg-slate-800 border border-stone-200 dark:border-slate-700 text-stone-800 dark:text-white rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent transition resize-none"></textarea>
                                        </div>
                                        <button type="submit" x-show="rating > 0" x-transition
                                            class="w-full bg-amber-500 hover:bg-amber-600 text-white font-bold text-sm py-2.5 rounded-xl transition shadow-md shadow-amber-500/20">
                                            Kirim Ulasan
                                        </button>
                                    </form>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>

                <div class="glass-card bg-white/70 dark:bg-slate-800/70 backdrop-blur-md border border-white/40 dark:border-slate-700/50 rounded-3xl px-5 py-4 flex items-center justify-between text-sm shadow-xl">
                    <span class="text-stone-500 dark:text-slate-400">Ingin melaporkan masalah lain?</span>
                    <a href="{{ route('lapor') }}"
                        class="text-brand-500 hover:text-brand-600 dark:text-brand-400 font-semibold transition flex items-center gap-1.5">
                        Buat laporan baru
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
            </div>

            @else

            <div class="hasil-masuk glass-card bg-white/70 dark:bg-slate-800/70 backdrop-blur-md border border-red-200 dark:border-red-500/20 rounded-3xl p-8 text-center shadow-xl">
                <div class="w-16 h-16 bg-red-100 dark:bg-red-500/10 rounded-2xl flex items-center justify-center mx-auto mb-4 border border-red-200 dark:border-red-500/20">
                    <svg class="w-8 h-8 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="text-lg font-bold text-stone-800 dark:text-white mb-2">Laporan Tidak Ditemukan</div>
                <div class="text-stone-500 dark:text-slate-400 text-sm mb-1">Tidak ada laporan dengan Tracking ID:</div>
                <div class="font-mono text-red-500 dark:text-red-400 font-bold text-lg mb-5">{{ $kodeLacak }}</div>
                <p class="text-stone-400 dark:text-slate-500 text-xs mb-6">Pastikan kamu memasukkan kode dengan benar, termasuk awalan
                    <span class="text-brand-500 font-semibold">SIGAP-</span> dan 6 karakter setelahnya.</p>
                <a href="{{ route('lapor') }}"
                    class="inline-flex items-center gap-2 bg-brand-500 hover:bg-brand-600 text-white text-sm font-semibold px-6 py-2.5 rounded-full transition shadow-md shadow-brand-500/20">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Buat Laporan Baru
                </a>
            </div>

            @endif
        @endisset

    </main>

    <footer class="bg-brand-600 dark:bg-slate-900 pt-10 pb-6 text-white transition-colors duration-300 mt-12">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                <div class="flex items-center gap-2">
                    <div class="w-7 h-7 bg-white/20 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <span class="font-bold text-lg tracking-tight">SIGAP BDG</span>
                </div>
                <p class="text-sm text-brand-200 dark:text-slate-500">© 2026 SIGAP BDG. Hak Cipta Dilindungi.</p>
                <div class="flex gap-5 text-sm text-brand-200 dark:text-slate-400">
                    <a href="{{ route('beranda') }}" class="hover:text-white transition">Beranda</a>
                    <a href="{{ route('lapor') }}" class="hover:text-white transition">Buat Laporan</a>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if(session('sukses_ulasan'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session("sukses_ulasan") }}',
            confirmButtonColor: '#f97316'
        });
    </script>
    @endif
</body>

</html>