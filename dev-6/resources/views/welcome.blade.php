<!DOCTYPE html>
<html lang="id" x-data="{ temaGelap: localStorage.getItem('temaGelap') === 'true' }"
    x-init="$watch('temaGelap', val => localStorage.setItem('temaGelap', val))" :class="{ 'dark': temaGelap }">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>SIGAP BDG - Lapor Cepat & Tanggap</title>

    <meta name="theme-color" content="#f97316">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta name="apple-mobile-web-app-title" content="SIGAP BDG">
    <link rel="apple-touch-icon" href="https://ui-avatars.com/api/?name=SIGAP+BDG&background=f97316&color=fff&size=180">
    <link rel="shortcut icon" href="https://ui-avatars.com/api/?name=SB&background=f97316&color=fff&size=32">

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

        .animate-float {
            animation: efekMengapung 3.5s ease-in-out infinite;
        }

        @keyframes efekMengapung {
            0% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-18px);
            }

            100% {
                transform: translateY(0px);
            }
        }
    </style>
</head>

<body class="bg-stone-50 dark:bg-slate-950 text-stone-800 dark:text-slate-100 transition-colors duration-300">

    <nav
        class="bg-white/80 dark:bg-slate-900/80 backdrop-blur-md sticky top-0 z-50 shadow-sm border-b border-stone-100 dark:border-slate-800">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 bg-brand-500 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <span class="font-bold text-xl tracking-tight text-stone-900 dark:text-white">SIGAP<span
                            class="text-brand-500">BDG</span></span>
                </div>

                <div class="hidden md:flex items-center space-x-8">
                    <a href="#"
                        class="text-stone-600 dark:text-slate-300 hover:text-brand-500 dark:hover:text-brand-400 font-medium transition">Beranda</a>
                    <a href="#fitur"
                        class="text-stone-600 dark:text-slate-300 hover:text-brand-500 dark:hover:text-brand-400 font-medium transition">Layanan</a>
                    <a href="#cara-kerja"
                        class="text-stone-600 dark:text-slate-300 hover:text-brand-500 dark:hover:text-brand-400 font-medium transition">Cara
                        Kerja</a>
                    <a href="{{ route('lacak') }}"
                        class="text-stone-600 dark:text-slate-300 hover:text-brand-500 dark:hover:text-brand-400 font-medium transition">Lacak</a>
                    <!-- ========================================================= -->
                    <!-- SPRINT 4 - FEATURE 6: Leaderboard & Poin Daerah [Dev 6] -->
                    <!-- ========================================================= -->
                    <a href="{{ route('leaderboard.indeks') }}"
                        class="text-stone-600 dark:text-slate-300 hover:text-brand-500 dark:hover:text-brand-400 font-medium transition">Leaderboard</a>
                    <!-- ========================================================= -->
                </div>

                <div class="hidden md:flex items-center gap-4">
                    <button @click="temaGelap = !temaGelap"
                        class="flex items-center justify-center w-10 h-10 rounded-full bg-stone-100 dark:bg-slate-800 text-stone-500 dark:text-slate-400 hover:text-brand-500 transition">
                        <span x-show="!temaGelap"><svg class="w-5 h-5" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                            </svg></span>
                        <span x-show="temaGelap"><svg class="w-5 h-5" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707M17.657 17.657l-.707-.707M6.343 6.343l-.707-.707M12 8a4 4 0 100 8 4 4 0 000-8z" />
                            </svg></span>
                    </button>
                    <a href="{{ route('lapor') }}"
                        class="bg-brand-500 hover:bg-brand-600 text-white px-6 py-2.5 rounded-full font-semibold transition shadow-md shadow-brand-500/20">Lapor
                        Sekarang</a>
                </div>

                <div class="md:hidden flex items-center gap-3">
                    <button @click="temaGelap = !temaGelap"
                        class="flex items-center justify-center w-8 h-8 rounded-full bg-stone-100 dark:bg-slate-800 text-stone-500 dark:text-slate-400">
                        <span x-show="!temaGelap"><svg class="w-4 h-4" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                            </svg></span>
                        <span x-show="temaGelap"><svg class="w-4 h-4" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707M17.657 17.657l-.707-.707M6.343 6.343l-.707-.707M12 8a4 4 0 100 8 4 4 0 000-8z" />
                            </svg></span>
                    </button>
                    <button class="text-stone-600 dark:text-slate-300 focus:outline-none">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <section class="relative pt-16 pb-24 px-4 sm:px-6 lg:px-8 max-w-6xl mx-auto overflow-hidden">

        <img src="{{ asset('images/hero-pelengkap.png') }}" alt="Aset Pelengkap"
            class="absolute top-10 right-10 w-32 md:w-48 opacity-40 dark:opacity-20 animate-float pointer-events-none"
            style="animation-delay: 1.5s;">

        <img src="{{ asset('images/gedung_sate.png') }}" alt="Gedung Sate Bandung"
            class="absolute top-1/2 md:bottom-0 md:top-auto left-1/2 md:left-0 -translate-x-1/2 md:translate-x-0 -translate-y-1/2 md:translate-y-0 w-[24rem] md:w-[32rem] lg:w-[40rem] opacity-20 dark:opacity-10 animate-float pointer-events-none -z-10"
            style="animation-delay: 2.5s;">

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center relative z-10">
            <div class="text-center lg:text-left order-2 lg:order-1">
                <h1
                    class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-stone-900 dark:text-white leading-tight mb-6">
                    Lapor Cepat & Mudah untuk <span class="text-brand-500">Kota Bandung</span>
                </h1>
                <p class="text-lg text-stone-500 dark:text-slate-400 mb-8 max-w-xl mx-auto lg:mx-0">
                    Temukan infrastruktur rusak atau keadaan darurat? Laporkan segera. Tanpa perlu mendaftar akun,
                    langsung terhubung dengan dinas terkait.
                </p>
                <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4">
                    <a href="{{ route('lapor') }}"
                        class="w-full sm:w-auto bg-brand-500 hover:bg-brand-600 text-white px-8 py-3.5 rounded-full font-bold text-lg transition shadow-lg shadow-brand-500/30">
                        Mulai Melapor
                    </a>
                    <button type="button"
                        class="w-full sm:w-auto flex items-center justify-center gap-2 bg-white dark:bg-slate-800 hover:bg-red-50 dark:hover:bg-red-900/30 text-red-600 border-2 border-red-100 dark:border-red-900/50 px-8 py-3 rounded-full font-bold text-lg transition shadow-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Darurat (110)
                    </button>
                </div>
            </div>
            <div class="order-1 lg:order-2 flex justify-center lg:justify-end relative">
                <div
                    class="absolute inset-0 bg-brand-200 dark:bg-brand-900/40 rounded-full blur-3xl opacity-40 transform scale-125">
                </div>

                <img src="{{ asset('images/hero-hp.png') }}" alt="Aplikasi SIGAP BDG"
                    class="w-full max-w-md lg:max-w-lg object-contain animate-float drop-shadow-2xl relative z-10 dark:hidden">

                <img src="{{ asset('images/hero-hp1.png') }}" alt="Aplikasi SIGAP BDG Gelap"
                    class="w-full max-w-md lg:max-w-lg object-contain animate-float drop-shadow-2xl relative z-10 hidden dark:block">
            </div>
        </div>
    </section>

    <section id="fitur" class="py-20 relative">
        <div class="absolute inset-0 bg-stone-100/50 dark:bg-slate-900/50"></div>
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
            <h2 class="text-sm font-bold tracking-widest text-brand-500 uppercase mb-2">Layanan Kami</h2>
            <h3 class="text-3xl md:text-4xl font-extrabold text-stone-900 dark:text-white mb-16">Portal Layanan Tersedia
            </h3>

            <div class="grid md:grid-cols-4 gap-8 pt-8">
                <div
                    class="relative bg-white/70 dark:bg-slate-800/70 backdrop-blur-md rounded-3xl p-8 shadow-xl border border-white/40 dark:border-slate-700/50 text-center transition-transform hover:-translate-y-2 duration-300 pt-16 mt-12 md:mt-0">
                    <div class="absolute -top-16 left-1/2 -translate-x-1/2">
                        <img src="{{ asset('images/icon-infrastruktur.png') }}" alt="Infrastruktur"
                            class="w-28 h-28 object-contain animate-float drop-shadow-lg">
                    </div>
                    <h4 class="text-xl font-bold text-stone-900 dark:text-white mb-3 mt-4">Lapor Infrastruktur</h4>
                    <p class="text-stone-500 dark:text-slate-400 text-sm leading-relaxed">
                        Jalan berlubang, lampu jalan mati, atau fasilitas publik rusak. Sistem AI akan mengestimasi
                        kerusakan.
                    </p>
                </div>

                <div
                    class="relative bg-white/70 dark:bg-slate-800/70 backdrop-blur-md rounded-3xl p-8 shadow-xl border border-white/40 dark:border-slate-700/50 text-center transition-transform hover:-translate-y-2 duration-300 pt-16 mt-12 md:mt-0">
                    <div class="absolute -top-16 left-1/2 -translate-x-1/2">
                        <img src="{{ asset('images/icon-kejahatan.png') }}" alt="Kejahatan"
                            class="w-28 h-28 object-contain animate-float drop-shadow-lg"
                            style="animation-delay: 0.5s;">
                    </div>
                    <h4 class="text-xl font-bold text-stone-900 dark:text-white mb-3 mt-4">Lapor Kejahatan</h4>
                    <p class="text-stone-500 dark:text-slate-400 text-sm leading-relaxed">
                        Laporan kerawanan atau tindak kriminal. Menambah titik panas pada peta keamanan kota.
                    </p>
                </div>

                <div
                    class="relative bg-white/70 dark:bg-slate-800/70 backdrop-blur-md rounded-3xl p-8 shadow-xl border border-white/40 dark:border-slate-700/50 text-center transition-transform hover:-translate-y-2 duration-300 pt-16 mt-12 md:mt-0">
                    <div class="absolute -top-16 left-1/2 -translate-x-1/2">
                        <img src="{{ asset('images/icon-lacak.png') }}" alt="Lacak Laporan"
                            class="w-28 h-28 object-contain animate-float drop-shadow-lg" style="animation-delay: 1s;">
                    </div>
                    <h4 class="text-xl font-bold text-stone-900 dark:text-white mb-3 mt-4">Lacak Laporan</h4>
                    <p class="text-stone-500 dark:text-slate-400 text-sm leading-relaxed">
                        Lacak setiap laporan yang Anda kirimkan menggunakan Tracking ID khusus. Ketahui progresnya.
                    </p>
                </div>

                <!-- ========================================================= -->
                <!-- SPRINT 4 - FEATURE 6: Leaderboard & Poin Daerah [Dev 6] -->
                <!-- ========================================================= -->
                <div
                    class="relative bg-white/70 dark:bg-slate-800/70 backdrop-blur-md rounded-3xl p-8 shadow-xl border border-white/40 dark:border-slate-700/50 text-center transition-transform hover:-translate-y-2 duration-300 pt-16 mt-12 md:mt-0">
                    <div class="absolute -top-16 left-1/2 -translate-x-1/2 flex items-center justify-center">
                        <div class="w-24 h-24 rounded-full bg-amber-500 border border-amber-600/30 flex items-center justify-center shadow-lg shadow-amber-500/20 animate-float" style="animation-delay: 1.5s;">
                            <svg class="w-12 h-12 text-white fill-current" viewBox="0 0 20 20">
                                <path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z" />
                            </svg>
                        </div>
                    </div>
                    <h4 class="text-xl font-bold text-stone-900 dark:text-white mb-3 mt-4">Papan Peringkat</h4>
                    <p class="text-stone-500 dark:text-slate-400 text-sm leading-relaxed mb-4">
                        Lihat peringkat kecamatan Ter-SIGAP Kota Bandung dan tingkat kepuasan ulasan warga.
                    </p>
                    <!-- <a href="{{ route('leaderboard.indeks') }}" class="text-xs font-bold text-brand-500 hover:text-brand-600 transition flex items-center justify-center gap-1.5 mt-2">
                        Lihat Papan Peringkat
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a> -->
                </div>
                <!-- ========================================================= -->
            </div>
        </div>
    </section>

    <section id="cara-kerja" class="py-24 bg-brand-50 dark:bg-slate-900">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row items-center gap-16">
                <div class="flex-1 w-full relative">
                    <div
                        class="bg-white dark:bg-slate-800 p-6 rounded-3xl shadow-lg border border-stone-100 dark:border-slate-700 relative z-10">
                        <div
                            class="aspect-[4/3] bg-stone-50 dark:bg-slate-900 rounded-2xl flex items-center justify-center border-2 border-dashed border-stone-200 dark:border-slate-700">
                            <div class="text-center">
                                <svg class="w-12 h-12 text-stone-300 dark:text-slate-600 mx-auto mb-3" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span class="text-stone-400 dark:text-slate-500 font-medium">Unggah Bukti Foto</span>
                            </div>
                        </div>
                    </div>
                    <div
                        class="absolute -bottom-8 -right-8 w-24 h-24 bg-[radial-gradient(#f97316_2px,transparent_2px)] [background-size:12px_12px] opacity-30">
                    </div>
                </div>

                <div class="flex-1">
                    <h2 class="text-sm font-bold tracking-widest text-brand-500 uppercase mb-2">Mudah & Simpel</h2>
                    <h3 class="text-3xl md:text-4xl font-extrabold text-stone-900 dark:text-white mb-8">Cara Kerja
                        Laporan</h3>

                    <div class="space-y-6">
                        <div class="flex items-start gap-4">
                            <div
                                class="w-10 h-10 rounded-full bg-brand-500 text-white font-bold flex items-center justify-center flex-shrink-0 mt-1 shadow-md shadow-brand-500/30">
                                1</div>
                            <div>
                                <h4 class="text-xl font-bold text-stone-900 dark:text-white mb-1">Ambil Foto</h4>
                                <p class="text-stone-500 dark:text-slate-400 text-sm leading-relaxed">Pastikan kerusakan
                                    terlihat jelas. Lokasi (GPS) akan dideteksi secara otomatis dari perangkat Anda.</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4">
                            <div
                                class="w-10 h-10 rounded-full bg-brand-500 text-white font-bold flex items-center justify-center flex-shrink-0 mt-1 shadow-md shadow-brand-500/30">
                                2</div>
                            <div>
                                <h4 class="text-xl font-bold text-stone-900 dark:text-white mb-1">Kirim & Terima Resi
                                </h4>
                                <p class="text-stone-500 dark:text-slate-400 text-sm leading-relaxed">Sistem AI akan
                                    mengevaluasi. Anda akan langsung menerima Tracking ID unik.</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4">
                            <div
                                class="w-10 h-10 rounded-full bg-brand-500 text-white font-bold flex items-center justify-center flex-shrink-0 mt-1 shadow-md shadow-brand-500/30">
                                3</div>
                            <div>
                                <h4 class="text-xl font-bold text-stone-900 dark:text-white mb-1">Pantau Tindak Lanjut
                                </h4>
                                <p class="text-stone-500 dark:text-slate-400 text-sm leading-relaxed">Gunakan fitur
                                    Lacak untuk melihat status pengerjaan oleh instansi terkait secara transparan.</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-10 flex gap-4">
                        <a href="{{ route('lapor') }}"
                            class="bg-brand-500 hover:bg-brand-600 text-white px-8 py-3 rounded-full font-bold transition shadow-md shadow-brand-500/20">Mulai
                            Lapor</a>
                        <a href="{{ route('lacak') }}"
                            class="bg-white dark:bg-slate-800 hover:bg-stone-50 dark:hover:bg-slate-700 text-stone-700 dark:text-slate-300 border border-stone-200 dark:border-slate-700 px-8 py-3 rounded-full font-bold transition">Lacak</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-24 bg-stone-50 dark:bg-slate-950 overflow-hidden relative">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-sm font-bold tracking-widest text-brand-500 uppercase mb-2">Suara Warga</h2>
                <h3 class="text-3xl md:text-4xl font-extrabold text-stone-900 dark:text-white">Ulasan Layanan SIGAP BDG</h3>
                <p class="mt-4 text-stone-500 dark:text-slate-400 max-w-2xl mx-auto text-sm">Apa kata warga yang telah menggunakan layanan pelaporan kami.</p>
            </div>

            @if(isset($ulasanBintang5) && $ulasanBintang5->count() > 0)
                <div class="flex flex-col sm:flex-row items-center justify-center gap-y-4 sm:gap-y-0 sm:-space-x-8 group">
                    @foreach($ulasanBintang5 as $i => $ulasan)
                        <div class="relative transition-all duration-300 ease-in-out hover:z-50 hover:-translate-y-4 hover:scale-105 group-hover:sm:mx-4 w-full sm:w-72 bg-white dark:bg-slate-800 p-6 rounded-3xl border border-stone-200 dark:border-slate-700 shadow-xl" style="z-index: {{ 10 - $i }}">
                            <div class="flex items-center gap-1 text-amber-400 mb-4">
                                @for($j = 0; $j < 5; $j++)
                                    <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" /></svg>
                                @endfor
                            </div>
                            <p class="text-stone-600 dark:text-slate-300 text-sm font-medium mb-6 line-clamp-4">"{{ $ulasan->ulasan }}"</p>
                            <div class="border-t border-stone-100 dark:border-slate-700 pt-4 mt-auto">
                                <div class="font-bold text-stone-900 dark:text-white text-sm">Warga Kota Bandung</div>
                                <div class="text-xs text-stone-500 dark:text-slate-400 mt-0.5">Laporan {{ $ulasan->laporanInfrastruktur->daerah->nama_daerah ?? 'Infrastruktur' }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <p class="text-stone-500 dark:text-slate-400">Belum ada ulasan untuk ditampilkan saat ini.</p>
                </div>
            @endif
        </div>
    </section>

    <footer class="bg-brand-600 dark:bg-slate-900 pt-16 pb-8 text-white transition-colors duration-300">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10 mb-12">
                <div class="lg:col-span-2">
                    <div class="flex items-center gap-2 mb-6">
                        <div class="w-8 h-8 bg-white dark:bg-brand-500 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-brand-600 dark:text-white" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                        </div>
                        <span class="font-bold text-xl tracking-tight text-white">SIGAP BDG</span>
                    </div>
                    <p class="text-brand-100 dark:text-slate-400 text-sm leading-relaxed max-w-sm">
                        Sistem Informasi Pelaporan Publik Kota Bandung. Mewujudkan kota yang aman, nyaman, dan responsif
                        terhadap kebutuhan warga.
                    </p>
                </div>

                <div>
                    <h5 class="font-bold text-lg mb-4 text-white">Tautan Pintas</h5>
                    <ul class="space-y-3 text-sm text-brand-100 dark:text-slate-400">
                        <li><a href="#" class="hover:text-white transition">Beranda</a></li>
                        <li><a href="{{ route('lapor') }}" class="hover:text-white transition">Buat Laporan</a></li>
                        <li><a href="{{ route('lacak') }}" class="hover:text-white transition">Lacak Laporan</a></li>
                    </ul>
                </div>

                <div>
                    <h5 class="font-bold text-lg mb-4 text-white">Kontak</h5>
                    <ul class="space-y-3 text-sm text-brand-100 dark:text-slate-400">
                        <li>Darurat: 110</li>
                        <li>Email: info@sigapbdg.go.id</li>
                        <li><a href="/portal-internal" class="hover:text-white transition underline">Portal
                                Administrator</a></li>
                    </ul>
                </div>
            </div>

            <div
                class="pt-8 border-t border-brand-500/50 dark:border-slate-800 flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-sm text-brand-200 dark:text-slate-500">© 2026 SIGAP BDG. Hak Cipta Dilindungi.</p>
                <div class="text-sm text-brand-200 dark:text-slate-500">
                    Dikelola oleh Pemerintah Kota Bandung
                </div>
            </div>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var statusBerhasil = '{{ session("success") }}';
            var statusPeringatan = '{{ session("warning") }}';
            var statusError = '{{ $errors->first() }}';

            var modeGelapSaatIni = document.documentElement.classList.contains('dark');
            var warnaLatarBelakang = modeGelapSaatIni ? '#1e293b' : '#ffffff';
            var warnaTeks = modeGelapSaatIni ? '#f8fafc' : '#1c1917';

            if (statusBerhasil) {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: statusBerhasil,
                    confirmButtonColor: '#f97316',
                    background: warnaLatarBelakang,
                    color: warnaTeks,
                    customClass: { popup: 'rounded-3xl', confirmButton: 'rounded-full px-6 py-2.5 font-bold' },
                    timer: 4000,
                    timerProgressBar: true
                });
            } else if (statusPeringatan) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Perhatian',
                    text: statusPeringatan,
                    confirmButtonColor: '#ea580c',
                    background: warnaLatarBelakang,
                    color: warnaTeks,
                    customClass: { popup: 'rounded-3xl', confirmButton: 'rounded-full px-6 py-2.5 font-bold' }
                });
            } else if (statusError) {
                Swal.fire({
                    icon: 'error',
                    title: 'Kesalahan!',
                    text: statusError,
                    confirmButtonColor: '#dc2626',
                    background: warnaLatarBelakang,
                    color: warnaTeks,
                    customClass: { popup: 'rounded-3xl', confirmButton: 'rounded-full px-6 py-2.5 font-bold' }
                });
            }
        });
    </script>

    <!-- ========================================================= -->
    <!-- SPRINT 4 - FEATURE 3: Asisten Virtual AI [Dev 3] -->
    <!-- ========================================================= -->
    <x-chatbot-widget />
    <!-- ========================================================= -->
</body>

</html>