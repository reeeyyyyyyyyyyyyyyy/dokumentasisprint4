@extends('admin.layout')

@section('judulHalaman', 'Detail Laporan')
@section('subjudulHalaman', 'Informasi lengkap dan pengelolaan status laporan')

@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
@endpush

@section('konten')
    <div class="space-y-5">

        <div class="flex items-center gap-3">
            <a href="{{ route('admin.laporan.indeks') }}"
                class="flex items-center gap-1.5 text-xs text-slate-500 hover:text-brand-600 dark:hover:text-brand-400 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Kembali ke Daftar
            </a>
            <span class="text-slate-300 dark:text-slate-700">/</span>
            <span class="text-xs text-slate-400 dark:text-slate-500 font-mono">{{ $dataLaporan->tracking_id }}</span>
        </div>

        <div class="grid lg:grid-cols-3 gap-5">

            <div class="lg:col-span-2 space-y-5">

                <div
                    class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl overflow-hidden shadow-sm">
                    <div class="px-5 py-4 border-b border-slate-100 dark:border-slate-800">
                        <div class="text-sm font-bold text-slate-800 dark:text-white mb-0.5">Foto Laporan</div>
                        <div class="text-xs text-slate-400 dark:text-slate-500">Foto yang diunggah oleh pelapor</div>
                    </div>
                    <div class="p-5">
                        <div
                            class="rounded-xl overflow-hidden bg-slate-50 dark:bg-slate-800 aspect-video flex items-center justify-center border border-slate-100 dark:border-slate-700/50">
                            <img src="{{ asset('storage/' . $dataLaporan->foto_awal) }}" alt="Foto kerusakan infrastruktur"
                                class="w-full h-full object-cover"
                                onerror="this.parentElement.innerHTML='<div class=\'flex flex-col items-center gap-2 text-slate-400 dark:text-slate-600\'><svg class=\'w-10 h-10\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'1.5\' d=\'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z\'/></svg><span class=\'text-sm\'>Foto tidak tersedia</span></div>'">
                        </div>
                    </div>
                </div>

                @if($dataLaporan->analisisAi)
                    @if($dataLaporan->analisisAi->is_spam)
                        <div
                            class="bg-red-50 dark:bg-red-950 border-2 border-red-200 dark:border-red-500/50 rounded-2xl p-5 shadow-sm">
                            <div class="flex items-start gap-3">
                                <div
                                    class="w-10 h-10 bg-red-100 dark:bg-red-500/20 rounded-xl flex items-center justify-center flex-shrink-0 mt-0.5">
                                    <svg class="w-5 h-5 text-red-500 dark:text-red-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                    </svg>
                                </div>
                                <div>
                                    <div class="text-red-600 dark:text-red-400 font-black text-sm uppercase tracking-widest mb-1">
                                        Laporan Terdeteksi Spam oleh AI</div>
                                    <div class="text-red-500 dark:text-red-300/70 text-xs leading-relaxed">Sistem analisis AI
                                        mendeteksi laporan ini sebagai tidak valid atau duplikat. Laporan ini tidak dapat diajukan
                                        untuk pendanaan.</div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div
                            class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl overflow-hidden shadow-sm">
                            <div class="px-5 py-4 border-b border-slate-100 dark:border-slate-800 flex items-center gap-2">
                                <svg class="w-4 h-4 text-slate-500 dark:text-slate-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                                </svg>
                                <div class="text-sm font-bold text-slate-700 dark:text-slate-300">Hasil Analisis AI</div>
                                <span
                                    class="ml-auto text-xs bg-green-100 text-green-800 border border-green-200 px-2 py-0.5 rounded-full font-semibold">
                                    Valid
                                </span>
                            </div>
                            <div class="p-5 space-y-3">
                                <div class="grid grid-cols-2 gap-3">
                                    <div
                                        class="bg-slate-50 dark:bg-slate-800 border border-slate-100 dark:border-slate-700/50 rounded-xl p-3">
                                        <div class="text-xs text-slate-500 dark:text-slate-400 mb-1">Jenis Kerusakan</div>
                                        <div class="text-sm font-bold text-slate-800 dark:text-white">
                                            {{ $dataLaporan->analisisAi->jenis_kerusakan }}
                                        </div>
                                    </div>
                                    <div
                                        class="bg-slate-50 dark:bg-slate-800 border border-slate-100 dark:border-slate-700/50 rounded-xl p-3">
                                        <div class="text-xs text-slate-500 dark:text-slate-400 mb-1">Tingkat Keparahan</div>
                                        <div
                                            class="text-sm font-bold {{ $dataLaporan->analisisAi->tingkat_keparahan === 'Berat' ? 'text-red-500 dark:text-red-400' : '' }} {{ $dataLaporan->analisisAi->tingkat_keparahan === 'Sedang' ? 'text-amber-500 dark:text-amber-400' : '' }} {{ $dataLaporan->analisisAi->tingkat_keparahan === 'Ringan' ? 'text-emerald-500 dark:text-emerald-400' : '' }}">
                                            {{ $dataLaporan->analisisAi->tingkat_keparahan }}
                                        </div>
                                    </div>
                                </div>
                                <div
                                    class="bg-slate-50 dark:bg-slate-800 border border-slate-100 dark:border-slate-700/50 rounded-xl p-3">
                                    <div class="text-xs text-slate-500 dark:text-slate-400 mb-1">Estimasi Biaya Perbaikan</div>
                                    <div class="text-lg font-black text-slate-800 dark:text-white">Rp
                                        {{ number_format($dataLaporan->analisisAi->estimasi_biaya, 0, ',', '.') }}
                                    </div>
                                </div>

                                <!-- ========================================================= -->
                                <!-- SPRINT 4 - FEATURE 4: Asisten AI Keputusan Admin [Dev 4] -->
                                <!-- ========================================================= -->
                                <a href="{{ route('admin.asisten-ai.indeks', ['laporan_id' => $dataLaporan->id]) }}"
                                    class="inline-flex items-center justify-center gap-2 w-full bg-indigo-600 hover:bg-indigo-500 text-white text-xs font-bold px-4 py-3 rounded-xl transition duration-200 shadow-md shadow-indigo-600/10 mt-3">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                    Analisis Asisten AI
                                </a>
                                <!-- ========================================================= -->
                            </div>
                        </div>
                    @endif
                @endif

                @if($dataLaporan->foto_selesai)
                    <div
                        class="bg-white dark:bg-slate-900 border border-green-200 dark:border-green-500/20 rounded-2xl overflow-hidden shadow-sm">
                        <div class="px-5 py-4 border-b border-green-100 dark:border-green-500/10 flex items-center gap-2">
                            <svg class="w-4 h-4 text-green-500 dark:text-green-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <div class="text-sm font-bold text-green-600 dark:text-green-400">Foto Setelah Perbaikan</div>
                        </div>
                        <div class="p-5">
                            <div
                                class="rounded-xl overflow-hidden bg-slate-50 dark:bg-slate-800 aspect-video border border-slate-100 dark:border-slate-700/50">
                                <img src="{{ asset('storage/' . $dataLaporan->foto_selesai) }}" alt="Foto selesai"
                                    class="w-full h-full object-cover">
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <div class="space-y-5">
                <div
                    class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-5 shadow-sm flex flex-col">
                    <div class="text-sm font-bold text-slate-800 dark:text-white mb-4">Lokasi Kejadian</div>
                    <div class="rounded-xl overflow-hidden border border-slate-200 dark:border-slate-700 relative w-full h-[250px] z-10"
                        id="map"></div>

                    <div class="mt-4 flex flex-wrap gap-2 text-xs text-slate-500 dark:text-slate-400 font-mono">
                        <span class="bg-slate-100 dark:bg-slate-800 px-2 py-1 rounded">Lat:
                            {{ $dataLaporan->latitude }}</span>
                        <span class="bg-slate-100 dark:bg-slate-800 px-2 py-1 rounded">Lng:
                            {{ $dataLaporan->longitude }}</span>
                    </div>

                    <a href="https://maps.google.com/?q={{ $dataLaporan->latitude }},{{ $dataLaporan->longitude }}"
                        target="_blank"
                        class="mt-3 inline-flex items-center gap-1.5 text-xs text-slate-600 dark:text-slate-400 hover:text-slate-800 dark:hover:text-white bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 border border-slate-200 dark:border-slate-700/50 px-3 py-2 rounded-lg transition w-full justify-center font-medium">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                        </svg>
                        Buka di Google Maps
                    </a>
                </div>

                <div
                    class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-5 shadow-sm">
                    <div class="text-sm font-bold text-slate-800 dark:text-white mb-4">Informasi Laporan</div>
                    <div class="space-y-3.5">
                        <div>
                            <div class="text-xs text-slate-500 dark:text-slate-400 mb-1">Tracking ID</div>
                            <div
                                class="font-mono text-brand-600 dark:text-brand-400 font-bold text-sm bg-brand-50 dark:bg-brand-900/30 px-3 py-2 rounded-lg border border-brand-100 dark:border-brand-800/50 inline-block">
                                {{ $dataLaporan->tracking_id }}
                            </div>
                        </div>
                        <div>
                            <div class="text-xs text-slate-500 dark:text-slate-400 mb-1">Daerah</div>
                            <div class="text-sm text-slate-800 dark:text-white font-medium">
                                {{ $dataLaporan->daerah->tingkat ?? '' }}
                                {{ $dataLaporan->daerah->nama_daerah ?? 'Tidak diketahui' }}
                            </div>
                        </div>
                        <div>
                            <div class="text-xs text-slate-500 dark:text-slate-400 mb-1">Tanggal Laporan</div>
                            <div class="text-sm text-slate-800 dark:text-white">
                                {{ $dataLaporan->created_at->translatedFormat('d F Y') }}
                            </div>
                            <div class="text-xs text-slate-500 dark:text-slate-400">
                                {{ $dataLaporan->created_at->translatedFormat('H:i') }} WIB ·
                                {{ $dataLaporan->created_at->diffForHumans() }}
                            </div>
                        </div>
                        <div>
                            <div class="text-xs text-slate-500 dark:text-slate-400 mb-1.5">Status Saat Ini</div>
                            <span
                                class="inline-flex items-center gap-1.5 text-sm font-bold px-3 py-1.5 rounded-lg border
                                                                                            {{ $dataLaporan->status === 'Menunggu' ? 'bg-amber-50 dark:bg-amber-900/20 text-amber-600 dark:text-amber-400 border-amber-200 dark:border-amber-800/50' : '' }}
                                                                                            {{ $dataLaporan->status === 'Proses' ? 'bg-brand-50 dark:bg-brand-900/20 text-brand-600 dark:text-brand-400 border-brand-200 dark:border-brand-800/50' : '' }}
                                                                                            {{ $dataLaporan->status === 'Selesai' ? 'bg-emerald-50 dark:bg-emerald-900/20 text-emerald-600 dark:text-emerald-400 border-emerald-200 dark:border-emerald-800/50' : '' }}
                                                                                            {{ $dataLaporan->status === 'Ditolak' ? 'bg-red-50 dark:bg-red-900/20 text-red-600 dark:text-red-400 border-red-200 dark:border-red-800/50' : ''}}">
                                {{ $dataLaporan->status}}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- ========================================================= -->
                <!-- SPRINT 4 - FEATURE 5: Audit Fisik & Timeline [Dev 5] -->
                <!-- ========================================================= -->
                @if(Auth::user()->role === 'Admin Daerah' && $dataLaporan->status !== 'Selesai' && $dataLaporan->status !== 'Ditolak' && (!isset($dataLaporan->analisisAi) || !$dataLaporan->analisisAi->is_spam))
                    <div
                        class="bg-white dark:bg-slate-900 border border-brand-200 dark:border-brand-500/20 rounded-2xl p-5 shadow-sm">
                        <div class="text-sm font-bold text-slate-800 dark:text-white mb-1">Perbarui Status</div>
                        <div class="text-xs text-slate-500 dark:text-slate-400 mb-4">Ubah status penanganan laporan ini</div>

                        <form action="{{ route('admin.laporan.perbarui', $dataLaporan->id) }}" method="POST"
                            enctype="multipart/form-data"
                            x-data="{ statusPilihan: '{{ $dataLaporan->status }}', namaFile: '' }">
                            @csrf
                            @method('PATCH')

                            <div class="mb-5">
                                <label class="block text-xs text-slate-600 dark:text-slate-400 font-medium mb-3">Pilih Status
                                    Baru</label>
                                <div class="grid grid-cols-3 gap-2">
                                    <label class="relative cursor-pointer">
                                        <input type="radio" name="status" value="Menunggu" x-model="statusPilihan"
                                            class="peer sr-only">
                                        <div
                                            class="w-full text-center px-3 py-2 text-xs font-semibold rounded-xl border transition-all peer-checked:bg-amber-50 peer-checked:text-amber-600 peer-checked:border-amber-200 dark:peer-checked:bg-amber-900/30 dark:peer-checked:text-amber-400 dark:peer-checked:border-amber-700 bg-slate-50 border-slate-200 text-slate-500 hover:bg-slate-100 dark:bg-slate-800 dark:border-slate-700 dark:text-slate-400 dark:hover:bg-slate-700">
                                            Menunggu
                                        </div>
                                    </label>
                                    <label class="relative cursor-pointer">
                                        <input type="radio" name="status" value="Proses" x-model="statusPilihan"
                                            class="peer sr-only">
                                        <div
                                            class="w-full text-center px-3 py-2 text-xs font-semibold rounded-xl border transition-all peer-checked:bg-brand-50 peer-checked:text-brand-600 peer-checked:border-brand-200 dark:peer-checked:bg-brand-900/30 dark:peer-checked:text-brand-400 dark:peer-checked:border-brand-700 bg-slate-50 border-slate-200 text-slate-500 hover:bg-slate-100 dark:bg-slate-800 dark:border-slate-700 dark:text-slate-400 dark:hover:bg-slate-700">
                                            Proses
                                        </div>
                                    </label>
                                    <label class="relative cursor-pointer">
                                        <input type="radio" name="status" value="Selesai" x-model="statusPilihan"
                                            class="peer sr-only">
                                        <div
                                            class="w-full text-center px-3 py-2 text-xs font-semibold rounded-xl border transition-all peer-checked:bg-emerald-50 peer-checked:text-emerald-600 peer-checked:border-emerald-200 dark:peer-checked:bg-emerald-900/30 dark:peer-checked:text-emerald-400 dark:peer-checked:border-emerald-700 bg-slate-50 border-slate-200 text-slate-500 hover:bg-slate-100 dark:bg-slate-800 dark:border-slate-700 dark:text-slate-400 dark:hover:bg-slate-700">
                                            Selesai
                                        </div>
                                    </label>
                                </div>
                            </div>

                            <div x-show="statusPilihan === 'Selesai'" x-collapse class="mb-5">
                                <label class="block text-xs text-slate-600 dark:text-slate-400 font-medium mb-2">Unggah Foto
                                    Perbaikan (Wajib)</label>
                                <div class="relative group" x-data="{ isDragging: false }" @dragover.prevent="isDragging = true"
                                    @dragleave.prevent="isDragging = false"
                                    @drop.prevent="isDragging = false; const dt = $event.dataTransfer; if(dt.files.length) { $refs.fileInput.files = dt.files; namaFile = dt.files[0].name; }">
                                    <input type="file" name="foto_selesai" id="foto_selesai" accept="image/*" x-ref="fileInput"
                                        class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10"
                                        @change="namaFile = $event.target.files.length > 0 ? $event.target.files[0].name : ''"
                                        :required="statusPilihan === 'Selesai'">
                                    <div :class="{'border-brand-500 bg-brand-50 dark:bg-brand-900/10': isDragging, 'border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800': !isDragging}"
                                        class="flex flex-col items-center justify-center p-6 border-2 border-dashed rounded-xl transition-colors duration-200 group-hover:border-brand-400 dark:group-hover:border-brand-500">
                                        <svg class="w-8 h-8 text-slate-400 dark:text-slate-500 mb-2" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                        </svg>
                                        <div class="text-sm font-medium text-slate-700 dark:text-slate-300">
                                            <span x-text="namaFile ? namaFile : 'Drag and drop foto ke sini'"></span>
                                        </div>
                                        <div x-show="!namaFile" class="text-xs text-slate-500 dark:text-slate-400 mt-1">atau
                                            klik untuk menelusuri</div>
                                    </div>
                                </div>
                                @error('foto_selesai')
                                    <div class="mt-1.5 text-xs text-red-500 dark:text-red-400">{{ $message }}</div>
                                @enderror
                            </div>

                            @error('status')
                                <div class="mb-3 text-xs text-red-500 dark:text-red-400">{{ $message }}</div>
                            @enderror

                            <button type="submit"
                                class="w-full bg-brand-600 hover:bg-brand-500 text-white font-bold text-sm py-2.5 rounded-xl transition flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                Simpan Perubahan
                            </button>
                        </form>

                    </div>
                @endif
                <!-- ========================================================= -->

                <!-- ========================================================= -->
                <!-- SPRINT 4 - FEATURE 1: Verifikasi Dana Khusus [Dev 1] -->
                <!-- ========================================================= -->
                @if(Auth::user()->role === 'Admin Daerah' && $dataLaporan->status === 'Proses' && $dataLaporan->analisisAi && !$dataLaporan->analisisAi->is_spam)
                <!-- ========================================================= -->
                    @php
                        $pengajuanTerkini = $dataLaporan->pengajuanDana->sortByDesc('waktu_pengajuan')->first();
                    @endphp
                    <div x-data="{ bukaModal: false, nominalInput: '' }"
                        class="bg-white dark:bg-slate-900 border border-brand-200 dark:border-brand-500/20 rounded-2xl p-5 shadow-sm">
                        <div class="flex items-center gap-2 mb-3">
                            <svg class="w-4 h-4 text-brand-500 dark:text-brand-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <div class="text-sm font-bold text-slate-800 dark:text-white">Pengajuan Dana Perbaikan</div>
                        </div>

                        @if(!$pengajuanTerkini)
                            <p class="text-xs text-slate-500 dark:text-slate-400 mb-4">Belum ada pengajuan dana untuk laporan ini.
                            </p>
                            <button type="button" @click="bukaModal = true"
                                class="w-full bg-brand-600 hover:bg-brand-500 text-white font-bold text-sm py-2.5 rounded-xl transition flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                                </svg>
                                Ajukan Dana
                            </button>
                        @elseif(in_array($pengajuanTerkini->status_approval, ['Menunggu', 'Proses']))
                            <div
                                class="flex items-center gap-2.5 bg-amber-50 dark:bg-amber-900/10 border border-amber-200 dark:border-amber-500/20 rounded-xl px-4 py-3">
                                <span class="w-2 h-2 rounded-full bg-amber-400 animate-pulse flex-shrink-0"></span>
                                <div>
                                    <div class="text-amber-600 dark:text-amber-400 font-bold text-sm">Dana sedang dalam proses
                                        pengajuan</div>
                                    <div class="text-amber-500 dark:text-amber-400/60 text-xs mt-0.5">Nominal: Rp
                                        {{ number_format($pengajuanTerkini->nominal_diajukan, 0, ',', '.') }} · Menunggu Super Admin
                                    </div>
                                </div>
                            </div>
                        @elseif($pengajuanTerkini->status_approval === 'Disetujui')
                            <!-- ========================================================= -->
                            <!-- SPRINT 4 - FEATURE 1: Verifikasi Dana Khusus [Dev 1] -->
                            <!-- ========================================================= -->
                            <div
                                class="flex items-start gap-2.5 bg-emerald-50 dark:bg-emerald-900/10 border border-emerald-200 dark:border-emerald-500/20 rounded-xl px-4 py-3">
                                <svg class="w-5 h-5 text-emerald-500 dark:text-emerald-400 flex-shrink-0 mt-0.5" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                <div>
                                    <div class="text-emerald-600 dark:text-emerald-400 font-bold text-sm">Dana telah disetujui</div>
                                    <div class="text-emerald-500 dark:text-emerald-400/60 text-xs mt-0.5">Nominal: Rp
                                        {{ number_format($pengajuanTerkini->nominal_diajukan, 0, ',', '.') }}
                                    </div>
                                    @if($pengajuanTerkini->catatan_approval)
                                        <div class="mt-2 text-xs text-emerald-700 dark:text-emerald-400/80 bg-emerald-100/50 dark:bg-emerald-950/40 p-2 rounded-lg border border-emerald-200/55 dark:border-emerald-900/30">
                                            <span class="font-bold">Catatan Super Admin:</span> "{{ $pengajuanTerkini->catatan_approval }}"
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <!-- ========================================================= -->
                        @elseif($pengajuanTerkini->status_approval === 'Ditolak')
                            <!-- ========================================================= -->
                            <!-- SPRINT 4 - FEATURE 1: Verifikasi Dana Khusus [Dev 1] -->
                            <!-- ========================================================= -->
                            <div
                                class="flex items-start gap-2.5 bg-red-50 dark:bg-red-900/10 border border-red-200 dark:border-red-500/20 rounded-xl px-4 py-3 mb-3">
                                <svg class="w-5 h-5 text-red-500 dark:text-red-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                <div>
                                    <div class="text-red-600 dark:text-red-400 font-bold text-sm">Pengajuan ditolak Super Admin
                                    </div>
                                    <div class="text-red-500 dark:text-red-400/60 text-xs mt-0.5">Nominal sebelumnya: Rp
                                        {{ number_format($pengajuanTerkini->nominal_diajukan, 0, ',', '.') }}
                                    </div>
                                    @if($pengajuanTerkini->catatan_approval)
                                        <div class="mt-2 text-xs text-red-700 dark:text-red-400/80 bg-red-100/50 dark:bg-red-950/40 p-2 rounded-lg border border-red-200/55 dark:border-red-900/30">
                                            <span class="font-bold">Catatan Super Admin:</span> "{{ $pengajuanTerkini->catatan_approval }}"
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <!-- ========================================================= -->
                            <button type="button" @click="bukaModal = true"
                                class="w-full bg-brand-600 hover:bg-brand-500 text-white font-bold text-sm py-2.5 rounded-xl transition flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                </svg>
                                Ajukan Ulang Dana
                            </button>
                        @endif

                        <div x-show="bukaModal" x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                            x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100"
                            x-transition:leave-end="opacity-0"
                            class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 backdrop-blur-sm"
                            style="display: none;" @click.self="bukaModal = false">
                            <div x-show="bukaModal" x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-150"
                                x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                                class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-white/10 rounded-2xl p-6 w-full max-w-sm mx-4 shadow-2xl">
                                <div class="flex items-center justify-between mb-5">
                                    <div class="font-bold text-slate-800 dark:text-white text-base">
                                        @if($pengajuanTerkini && $pengajuanTerkini->status_approval === 'Ditolak')
                                            Ajukan Ulang Dana
                                        @else
                                            Ajukan Dana Perbaikan
                                        @endif
                                    </div>
                                    <button @click="bukaModal = false"
                                        class="text-slate-400 hover:text-slate-600 dark:text-slate-500 dark:hover:text-white transition">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>

                                @if($pengajuanTerkini && $pengajuanTerkini->status_approval === 'Ditolak')
                                    <form @submit.prevent="if(nominalInput > 0) { $el.submit() }"
                                        action="{{ route('admin.pengajuan.ajukan-ulang', $pengajuanTerkini->id) }}" method="POST">
                                @else
                                        <form @submit.prevent="if(nominalInput > 0) { $el.submit() }"
                                            action="{{ route('admin.pengajuan.simpan') }}" method="POST">
                                            <input type="hidden" name="id_laporan" value="{{ $dataLaporan->id }}">
                                    @endif
                                        @csrf
                                        <div class="mb-4">
                                            <label
                                                class="block text-xs text-slate-600 dark:text-slate-400 font-medium mb-2">Nominal
                                                Dana yang Dibutuhkan (Rp)</label>
                                            <div class="relative">
                                                <span
                                                    class="absolute left-3 top-1/2 -translate-y-1/2 text-sm text-slate-400 dark:text-slate-500 font-semibold">Rp</span>
                                                <input type="number" name="nominal_diajukan" x-model="nominalInput" min="1000"
                                                    placeholder="0"
                                                    class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-white text-sm rounded-xl pl-10 pr-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent transition"
                                                    required>
                                            </div>
                                            <div x-show="nominalInput !== '' && nominalInput <= 0"
                                                class="mt-1.5 text-xs text-red-500 dark:text-red-400">Nominal harus lebih dari 0
                                            </div>
                                        </div>
                                        <div class="flex gap-2">
                                            <button type="button" @click="bukaModal = false"
                                                class="flex-1 bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-600 dark:text-slate-300 font-semibold text-sm py-2.5 rounded-xl transition">Batal</button>
                                            <button type="submit"
                                                class="flex-1 bg-brand-600 hover:bg-brand-500 text-white font-bold text-sm py-2.5 rounded-xl transition">Kirim
                                                Pengajuan</button>
                                        </div>
                                    </form>

                                    <div class="mt-4 pt-4 border-t border-slate-100 dark:border-white/5 text-center">
                                        <div class="text-xs text-slate-500 dark:text-slate-600">Pengajuan diteruskan ke Super
                                            Admin untuk disetujui</div>
                                    </div>
                            </div>
                        </div>
                    </div>
                @endif

                @if($dataLaporan->ulasanLaporan->count() > 0)
                    <div
                        class="mt-6 bg-white dark:bg-slate-900 border border-brand-200 dark:border-brand-500/20 rounded-2xl p-5 shadow-sm">
                        <div class="text-sm font-bold text-slate-800 dark:text-white mb-3 flex items-center gap-2">
                            <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                            </svg>
                            Ulasan dari Warga ({{ $dataLaporan->ulasanLaporan->count() }})
                        </div>
                        <div class="space-y-3 max-h-64 overflow-y-auto pr-2">
                            @foreach($dataLaporan->ulasanLaporan as $ulasanData)
                                <div
                                    class="bg-stone-50 dark:bg-slate-800/50 p-4 rounded-xl border border-stone-100 dark:border-slate-700/50">
                                    <div class="flex items-center gap-1 mb-2">
                                        @for($i = 1; $i <= 5; $i++)
                                            <svg class="w-5 h-5 {{ $i <= $ulasanData->rating ? 'text-amber-400 fill-amber-400' : 'text-stone-300 dark:text-slate-600' }}"
                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                            </svg>
                                        @endfor
                                        <span
                                            class="text-xs text-slate-400 ml-auto">{{ $ulasanData->created_at->diffForHumans() }}</span>
                                    </div>
                                    @if($ulasanData->ulasan)
                                        <p class="text-sm text-stone-600 dark:text-slate-300 italic">"{{ $ulasanData->ulasan }}"</p>
                                    @else
                                        <p class="text-sm text-stone-400 dark:text-slate-500 italic">(Tidak ada ulasan tertulis)</p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var map = L.map('map').setView([{{ $dataLaporan->latitude }}, {{ $dataLaporan->longitude }}], 18);

            L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
                attribution: 'Tiles &copy; Esri &mdash; Source: Esri, i-cubed, USDA, USGS, AEX, GeoEye, Getmapping, Aerogrid, IGN, IGP, UPR-EGP, and the GIS User Community'
            }).addTo(map);

            var iconMarker = L.icon({
                iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-red.png',
                shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
                iconSize: [25, 41],
                iconAnchor: [12, 41],
                popupAnchor: [1, -34],
                shadowSize: [41, 41]
            });

            L.marker([{{ $dataLaporan->latitude }}, {{ $dataLaporan->longitude }}], { icon: iconMarker })
                .addTo(map)
                .bindPopup('<div class="text-center"><div class="font-bold mb-1">Lokasi Kejadian</div><a href="https://maps.google.com/?q={{ $dataLaporan->latitude }},{{ $dataLaporan->longitude }}" target="_blank" class="text-brand-600 hover:text-brand-700 hover:underline inline-block mt-1">Buka di Google Maps</a></div>');
        });
    </script>
@endpush