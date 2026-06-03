<!DOCTYPE html>
<html lang="id" x-data="{ temaGelap: localStorage.getItem('temaGelap') === 'true' }"
    x-init="$watch('temaGelap', val => localStorage.setItem('temaGelap', val))" :class="{ 'dark': temaGelap }">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Papan Peringkat Kecamatan - SIGAP BDG</title>
    <meta name="description"
        content="Papan peringkat kinerja kecamatan (Kecamatan Ter-SIGAP) Kota Bandung dalam penanganan laporan warga.">

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

        .glass-card {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }

        .dark .glass-card {
            background: rgba(30, 41, 59, 0.7);
        }

        .podium-gold {
            background: linear-gradient(135deg, #fef08a, #eab308);
            box-shadow: 0 10px 25px -5px rgba(234, 179, 8, 0.3);
        }

        .podium-silver {
            background: linear-gradient(135deg, #e2e8f0, #94a3b8);
            box-shadow: 0 10px 25px -5px rgba(148, 163, 184, 0.3);
        }

        .podium-bronze {
            background: linear-gradient(135deg, #ffedd5, #c2410c);
            box-shadow: 0 10px 25px -5px rgba(194, 65, 12, 0.3);
        }
    </style>
</head>

<body
    class="bg-stone-50 dark:bg-slate-950 text-stone-800 dark:text-slate-100 transition-colors duration-300 min-h-screen flex flex-col">

    <!-- ========================================================= -->
    <!-- SPRINT 4 - FEATURE 6: Leaderboard & Poin Daerah [Dev 6] -->
    <!-- ========================================================= -->

    <nav
        class="bg-white/80 dark:bg-slate-900/80 backdrop-blur-md sticky top-0 z-40 shadow-sm border-b border-stone-100 dark:border-slate-800">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <a href="{{ route('beranda') }}" class="flex items-center gap-2">
                    <div
                        class="w-8 h-8 bg-brand-500 rounded-lg flex items-center justify-center shadow-md shadow-brand-500/30">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <span class="font-bold text-xl tracking-tight text-stone-900 dark:text-white">SIGAP<span
                            class="text-brand-500">BDG</span></span>
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

    <main class="flex-1 w-full max-w-5xl mx-auto px-4 sm:px-6 pt-10 pb-20">

        <!-- Header -->
        <div class="text-center mb-12">
            <div
                class="inline-flex items-center gap-2 bg-amber-100 dark:bg-amber-500/10 border border-amber-200 dark:border-amber-500/20 text-amber-700 dark:text-amber-400 text-xs font-bold px-3.5 py-1.5 rounded-full mb-4">
                <svg class="w-4 h-4 fill-amber-400 text-amber-500" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Peringkat Kinerja Kecamatan
            </div>
            <h1 class="text-4xl md:text-5xl font-black text-stone-900 dark:text-white leading-tight mb-4">
                Kecamatan Ter-<span class="gradient-text">SIGAP</span> Bandung
            </h1>
            <p class="text-stone-500 dark:text-slate-400 text-sm max-w-xl mx-auto leading-relaxed">
                Papan peringkat real-time yang mengapresiasi kinerja Kecamatan di Kota Bandung berdasarkan kecepatan
                penanganan krisis dan tingkat kepuasan ulasan warga.
            </p>
        </div>

        @if($leaderboard->count() >= 3)
            <!-- Podium 3 Besar -->
            <div class="grid grid-cols-3 gap-3 sm:gap-6 items-end max-w-2xl mx-auto mb-16 px-2 sm:px-0">
                <!-- Peringkat 2 (Perak) - Kiri -->
                <div class="flex flex-col items-center order-1">
                    <div
                        class="w-12 h-12 rounded-full border-4 border-slate-300 dark:border-slate-600 bg-slate-200 dark:bg-slate-800 flex items-center justify-center font-bold text-slate-700 dark:text-slate-300 text-lg shadow-md mb-2">
                        2</div>
                    <div class="text-center mb-3">
                        <div class="text-xs font-bold text-stone-800 dark:text-white truncate max-w-[100px] sm:max-w-none">
                            {{ $leaderboard[1]->nama_daerah }}</div>
                        <div class="text-[10px] text-stone-400 font-mono">
                            {{ number_format($leaderboard[1]->total_poin, 0, ',', '.') }} Poin</div>
                    </div>
                    <div
                        class="podium-silver w-full h-24 sm:h-32 rounded-t-2xl flex flex-col justify-end p-4 text-center text-white">
                        <svg class="w-6 h-6 mx-auto mb-1 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5a2 2 0 10-2 2h2z" />
                        </svg>
                        <span class="text-[10px] uppercase font-bold tracking-wider opacity-90">Perak</span>
                    </div>
                </div>

                <!-- Peringkat 1 (Emas) - Tengah (Tinggi) -->
                <div class="flex flex-col items-center order-2">
                    <div class="relative mb-2">
                        <div class="absolute -top-6 left-1/2 -translate-x-1/2 text-yellow-500 animate-bounce">
                            <svg class="w-6 h-6 fill-yellow-500" viewBox="0 0 20 20" fill="currentColor">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                            </svg>
                        </div>
                        <div
                            class="w-16 h-16 rounded-full border-4 border-yellow-400 dark:border-yellow-500 bg-yellow-100 dark:bg-yellow-950 flex items-center justify-center font-black text-yellow-700 dark:text-yellow-400 text-2xl shadow-lg">
                            1</div>
                    </div>
                    <div class="text-center mb-3">
                        <div class="text-sm font-black text-stone-900 dark:text-white truncate max-w-[120px] sm:max-w-none">
                            {{ $leaderboard[0]->nama_daerah }}</div>
                        <div class="text-xs font-black text-brand-600 dark:text-brand-400 font-mono">
                            {{ number_format($leaderboard[0]->total_poin, 0, ',', '.') }} Poin</div>
                    </div>
                    <div
                        class="podium-gold w-full h-36 sm:h-44 rounded-t-2xl flex flex-col justify-end p-4 text-center text-yellow-950">
                        <svg class="w-8 h-8 mx-auto mb-2 opacity-90 fill-yellow-950" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path
                                d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z" />
                        </svg>
                        <span class="text-xs uppercase font-extrabold tracking-widest">Emas</span>
                    </div>
                </div>

                <!-- Peringkat 3 (Perunggu) - Kanan -->
                <div class="flex flex-col items-center order-3">
                    <div
                        class="w-12 h-12 rounded-full border-4 border-amber-600 dark:border-amber-700 bg-amber-50 dark:bg-amber-950 flex items-center justify-center font-bold text-amber-800 dark:text-amber-400 text-lg shadow-md mb-2">
                        3</div>
                    <div class="text-center mb-3">
                        <div class="text-xs font-bold text-stone-800 dark:text-white truncate max-w-[100px] sm:max-w-none">
                            {{ $leaderboard[2]->nama_daerah }}</div>
                        <div class="text-[10px] text-stone-400 font-mono">
                            {{ number_format($leaderboard[2]->total_poin, 0, ',', '.') }} Poin</div>
                    </div>
                    <div
                        class="podium-bronze w-full h-20 sm:h-28 rounded-t-2xl flex flex-col justify-end p-4 text-center text-white">
                        <svg class="w-5 h-5 mx-auto mb-1 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                        <span class="text-[10px] uppercase font-bold tracking-wider opacity-90">Perunggu</span>
                    </div>
                </div>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Sidebar Aturan Poin -->
            <div class="lg:col-span-1 space-y-6">
                <div
                    class="glass-card bg-white/70 dark:bg-slate-900/70 border border-white/40 dark:border-slate-800 rounded-3xl p-6 shadow-xl">
                    <h3 class="text-lg font-bold text-stone-850 dark:text-white mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Bagaimana Poin Dihitung?
                    </h3>
                    <p class="text-xs text-stone-500 dark:text-slate-400 leading-relaxed mb-4">
                        Poin kontribusi daerah ditambahkan secara otomatis oleh sistem saat milestone pengerjaan
                        dicapai:
                    </p>
                    <div class="space-y-4">
                        <div class="flex items-start gap-3">
                            <div
                                class="w-8 h-8 rounded-lg bg-indigo-50 dark:bg-indigo-950/20 flex items-center justify-center text-xs font-bold text-indigo-600 dark:text-indigo-400 flex-shrink-0 mt-0.5">
                                +10</div>
                            <div>
                                <div class="text-xs font-bold text-stone-700 dark:text-slate-300">Laporan Baru Masuk
                                </div>
                                <p class="text-[10px] text-stone-400 dark:text-slate-500 leading-normal">Setiap
                                    partisipasi aktif warga mengirimkan laporan awal.</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <div
                                class="w-8 h-8 rounded-lg bg-amber-50 dark:bg-amber-950/20 flex items-center justify-center text-xs font-bold text-amber-600 dark:text-amber-400 flex-shrink-0 mt-0.5">
                                +20</div>
                            <div>
                                <div class="text-xs font-bold text-stone-700 dark:text-slate-300">Pembaruan ke Status
                                    Proses</div>
                                <p class="text-[10px] text-stone-400 dark:text-slate-500 leading-normal">Kecepatan
                                    respon admin memverifikasi & menjadwalkan perbaikan.</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <div
                                class="w-8 h-8 rounded-lg bg-emerald-50 dark:bg-emerald-950/20 flex items-center justify-center text-xs font-bold text-emerald-600 dark:text-emerald-400 flex-shrink-0 mt-0.5">
                                +50</div>
                            <div>
                                <div class="text-xs font-bold text-stone-700 dark:text-slate-300">Penyelesaian Laporan
                                    (Selesai)</div>
                                <p class="text-[10px] text-stone-400 dark:text-slate-500 leading-normal">Penyelesaian
                                    fisik pekerjaan perbaikan di lapangan.</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <div
                                class="w-8 h-8 rounded-lg bg-rose-50 dark:bg-rose-950/20 flex items-center justify-center text-xs font-bold text-rose-600 dark:text-rose-400 flex-shrink-0 mt-0.5">
                                Vrs</div>
                            <div>
                                <div class="text-xs font-bold text-stone-700 dark:text-slate-300">Ulasan Warga (Rating *
                                    10)</div>
                                <p class="text-[10px] text-stone-400 dark:text-slate-500 leading-normal">Kepuasan warga
                                    atas kualitas hasil perbaikan (Bintang 1-5).</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabel Papan Peringkat Utama -->
            <script id="leaderboard-data" type="application/json">
                {!! json_encode($leaderboard) !!}
            </script>
            <div class="lg:col-span-2 space-y-4" x-data="{ 
                pencarian: '',
                halaman: 1,
                perHalaman: 5,
                semuaItem: [],
                init() {
                    this.semuaItem = JSON.parse(document.getElementById('leaderboard-data').textContent);
                },
                get totalHalaman() {
                    return Math.ceil(this.filteredItems.length / this.perHalaman) || 1;
                },
                get filteredItems() {
                    if (!this.pencarian) {
                        return this.semuaItem;
                    }
                    return this.semuaItem.filter(item => 
                        item.nama_daerah.toLowerCase().includes(this.pencarian.toLowerCase())
                    );
                },
                get paginatedItems() {
                    const start = (this.halaman - 1) * this.perHalaman;
                    return this.filteredItems.slice(start, start + this.perHalaman);
                },
                getStartIndex() {
                    if (this.filteredItems.length === 0) return 0;
                    return (this.halaman - 1) * this.perHalaman + 1;
                },
                getEndIndex() {
                    const end = this.halaman * this.perHalaman;
                    return end > this.filteredItems.length ? this.filteredItems.length : end;
                }
            }" x-init="$watch('pencarian', () => halaman = 1)">
                <div
                    class="glass-card bg-white/70 dark:bg-slate-900/70 border border-white/40 dark:border-slate-800 rounded-3xl p-5 sm:p-6 shadow-xl">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
                        <div class="text-sm font-bold text-stone-850 dark:text-white">Daftar Peringkat Kecamatan</div>
                        <div class="relative w-full sm:w-64">
                            <span
                                class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-stone-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </span>
                            <input type="text" x-model="pencarian" placeholder="Cari Kecamatan..."
                                class="w-full bg-stone-50 dark:bg-slate-950 border border-stone-200 dark:border-slate-700 text-stone-800 dark:text-white text-xs rounded-xl pl-9 pr-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent transition">
                        </div>
                    </div>

                    <div
                        class="overflow-x-auto rounded-2xl border border-stone-100 dark:border-slate-800 bg-white/30 dark:bg-slate-900/30">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr
                                    class="bg-stone-50/50 dark:bg-slate-950/30 text-stone-500 dark:text-slate-400 text-[10px] font-bold uppercase tracking-wider border-b border-stone-100 dark:border-slate-800">
                                    <th class="px-4 py-3 text-center w-14">Rank</th>
                                    <th class="px-4 py-3">Kecamatan</th>
                                    <th class="px-4 py-3 text-center">Total Laporan</th>
                                    <th class="px-4 py-3 text-center">Rasio Selesai</th>
                                    <th class="px-4 py-3 text-center">Kepuasan</th>
                                    <th class="px-4 py-3 text-right pr-6">Poin</th>
                                </tr>
                        </table>
                        </table>
                    </div>

                    <div
                        class="overflow-x-auto rounded-2xl border border-stone-100 dark:border-slate-800 bg-white/30 dark:bg-slate-900/30 -mt-2">
                        <table class="w-full text-left border-collapse">
                            <tbody>
                                <template x-for="item in paginatedItems" :key="item.id">
                                    <tr
                                        class="border-b border-stone-100 dark:border-slate-800/80 hover:bg-stone-50/30 dark:hover:bg-slate-800/20 transition-colors">
                                        <td class="px-4 py-4 text-center font-bold text-xs w-14">
                                            <template x-if="item.rank === 1">
                                                <span
                                                    class="inline-flex w-6 h-6 rounded-full bg-yellow-400/20 text-yellow-600 dark:bg-yellow-500/10 dark:text-yellow-400 items-center justify-center text-[10px]">1st</span>
                                            </template>
                                            <template x-if="item.rank === 2">
                                                <span
                                                    class="inline-flex w-6 h-6 rounded-full bg-slate-300/30 text-slate-600 dark:bg-slate-500/10 dark:text-slate-400 items-center justify-center text-[10px]">2nd</span>
                                            </template>
                                            <template x-if="item.rank === 3">
                                                <span
                                                    class="inline-flex w-6 h-6 rounded-full bg-amber-600/20 text-amber-700 dark:bg-amber-600/10 dark:text-amber-400 items-center justify-center text-[10px]">3rd</span>
                                            </template>
                                            <template x-if="item.rank > 3">
                                                <span class="text-stone-400 dark:text-slate-500"
                                                    x-text="item.rank"></span>
                                            </template>
                                        </td>
                                        <td class="px-4 py-4">
                                            <div class="text-xs font-bold text-stone-850 dark:text-white"
                                                x-text="item.nama_daerah"></div>
                                        </td>
                                        <td class="px-4 py-4 text-center text-xs text-stone-600 dark:text-slate-300"
                                            x-text="item.total_laporan">
                                        </td>
                                        <td class="px-4 py-4 text-center">
                                            <span class="text-xs font-semibold text-stone-700 dark:text-slate-300"
                                                x-text="item.rasio_penyelesaian + '%'"></span>
                                            <div
                                                class="w-16 h-1 bg-stone-100 dark:bg-slate-800 rounded-full mx-auto mt-1 overflow-hidden">
                                                <div class="h-full bg-brand-500 rounded-full"
                                                    :style="'width: ' + item.rasio_penyelesaian + '%'"></div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-4 text-center">
                                            <div class="flex items-center justify-center gap-1">
                                                <svg class="w-3.5 h-3.5 text-amber-400 fill-amber-400"
                                                    viewBox="0 0 20 20" fill="currentColor">
                                                    <path
                                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                                </svg>
                                                <span class="text-xs font-semibold text-stone-700 dark:text-slate-300"
                                                    x-text="item.rata_rating > 0 ? item.rata_rating : '-'">
                                                </span>
                                            </div>
                                        </td>
                                        <td class="px-4 py-4 text-right pr-6 font-bold text-xs text-brand-600 dark:text-brand-400 font-mono"
                                            x-text="new Intl.NumberFormat('id-ID').format(item.total_poin)">
                                        </td>
                                    </tr>
                                </template>
                                <template x-if="paginatedItems.length === 0">
                                    <tr>
                                        <td colspan="6"
                                            class="px-4 py-8 text-center text-xs text-stone-500 dark:text-slate-400">
                                            Kecamatan tidak ditemukan.
                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination Controls -->
                    <div
                        class="flex items-center justify-between mt-5 pt-4 border-t border-stone-100 dark:border-slate-800 text-xs">
                        <div class="text-stone-500 dark:text-slate-400">
                            Menampilkan <span class="font-semibold text-stone-750 dark:text-white"
                                x-text="getStartIndex()"></span>
                            - <span class="font-semibold text-stone-750 dark:text-white" x-text="getEndIndex()"></span>
                            dari <span class="font-semibold text-stone-750 dark:text-white"
                                x-text="filteredItems.length"></span> kecamatan
                        </div>
                        <div class="flex items-center gap-2">
                            <!-- Prev Button -->
                            <button @click="if (halaman > 1) halaman--" :disabled="halaman === 1"
                                class="inline-flex items-center justify-center w-8.5 h-8.5 rounded-xl border border-stone-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-stone-600 dark:text-slate-400 hover:bg-stone-50 dark:hover:bg-slate-800 disabled:opacity-40 disabled:pointer-events-none transition shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 19l-7-7 7-7" />
                                </svg>
                            </button>

                            <!-- Page Indicator -->
                            <span class="text-stone-550 dark:text-slate-400 min-w-[70px] text-center font-medium">
                                <span class="font-semibold text-stone-800 dark:text-white" x-text="halaman"></span> /
                                <span x-text="totalHalaman"></span>
                            </span>

                            <!-- Next Button -->
                            <button @click="if (halaman < totalHalaman) halaman++" :disabled="halaman === totalHalaman"
                                class="inline-flex items-center justify-center w-8.5 h-8.5 rounded-xl border border-stone-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-stone-600 dark:text-slate-400 hover:bg-stone-50 dark:hover:bg-slate-800 disabled:opacity-40 disabled:pointer-events-none transition shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

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

    <!-- ========================================================= -->
</body>

</html>