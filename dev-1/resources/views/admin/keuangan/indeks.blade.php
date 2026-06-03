@extends('admin.layout')

@section('judulHalaman', 'Persetujuan Dana')
@section('subjudulHalaman', 'Kelola semua pengajuan dana perbaikan infrastruktur')

@section('konten')
    <div class="space-y-5">

        @php
            // =========================================================
            // SPRINT 4 - FEATURE 1: Verifikasi Dana Khusus [Dev 1]
            // =========================================================
            $totalMenunggu = \App\Models\PengajuanDana::where('status_approval', 'Menunggu')->count();
            $totalDisetujui = \App\Models\PengajuanDana::where('status_approval', 'Disetujui')->count();
            $totalDitolak = \App\Models\PengajuanDana::where('status_approval', 'Ditolak')->count();
            $totalPengajuan = $totalMenunggu + $totalDisetujui + $totalDitolak;
            // =========================================================
        @endphp

        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-5 shadow-sm">
                <div class="w-10 h-10 bg-slate-100 dark:bg-slate-800 rounded-xl flex items-center justify-center mb-4">
                    <svg class="w-5 h-5 text-slate-500 dark:text-slate-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
                <div class="text-2xl font-extrabold text-slate-800 dark:text-white">{{ $totalPengajuan }}</div>
                <div class="text-xs text-slate-400 mt-0.5">Total Pengajuan</div>
            </div>
            <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-5 shadow-sm">
                <div class="w-10 h-10 bg-amber-50 dark:bg-amber-900/20 rounded-xl flex items-center justify-center mb-4">
                    <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="text-2xl font-extrabold text-amber-500">{{ $totalMenunggu }}</div>
                <div class="text-xs text-slate-400 mt-0.5">Menunggu Review</div>
            </div>
            <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-5 shadow-sm">
                <div
                    class="w-10 h-10 bg-emerald-50 dark:bg-emerald-900/20 rounded-xl flex items-center justify-center mb-4">
                    <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <div class="text-2xl font-extrabold text-emerald-500">{{ $totalDisetujui }}</div>
                <div class="text-xs text-slate-400 mt-0.5">Disetujui</div>
            </div>
            <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-5 shadow-sm">
                <div class="w-10 h-10 bg-red-50 dark:bg-red-900/20 rounded-xl flex items-center justify-center mb-4">
                    <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </div>
                <div class="text-2xl font-extrabold text-red-500">{{ $totalDitolak }}</div>
                <div class="text-xs text-slate-400 mt-0.5">Ditolak</div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-5 shadow-sm">
                <h3 class="text-sm font-bold text-slate-800 dark:text-white mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Sebaran Nominal Pengajuan (Rp)
                </h3>
                <div class="relative w-full h-64 flex justify-center">
                    <canvas id="financeChart"></canvas>
                </div>
            </div>
            <div
                class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-5 shadow-sm flex flex-col justify-center">
                <div class="space-y-6">
                    <div>
                        <div class="text-xs text-slate-400 font-semibold uppercase tracking-wider mb-1">Total Dana Disetujui
                        </div>
                        <div class="text-3xl font-extrabold text-emerald-500">Rp
                            {{ number_format($danaDisetujui, 0, ',', '.') }}</div>
                    </div>
                    <div>
                        <div class="text-xs text-slate-400 font-semibold uppercase tracking-wider mb-1">Total Dana Menunggu
                        </div>
                        <div class="text-2xl font-bold text-amber-500">Rp {{ number_format($danaMenunggu, 0, ',', '.') }}
                        </div>
                    </div>
                    <div>
                        <div class="text-xs text-slate-400 font-semibold uppercase tracking-wider mb-1">Total Dana Ditolak
                        </div>
                        <div class="text-2xl font-bold text-red-500">Rp {{ number_format($danaDitolak, 0, ',', '.') }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ========================================================= -->
        <!-- SPRINT 4 - FEATURE 1: Verifikasi Dana Khusus [Dev 1] -->
        <!-- ========================================================= -->
        <div x-data="{ tabPilihan: 'standar', modalTerbuka: false, idPengajuan: null, nominalPengajuan: 0, statusKeputusan: '' }"
            class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl overflow-hidden shadow-sm">
            <div class="px-5 py-4 border-b border-slate-100 dark:border-slate-800 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                <div>
                    <div class="text-sm font-bold text-slate-800 dark:text-white">Daftar Pengajuan Dana</div>
                    <div class="text-xs text-slate-400 mt-0.5">Kelola dan tinjau pengajuan anggaran perbaikan</div>
                </div>
                <div class="flex items-center gap-1.5 bg-slate-100 dark:bg-slate-800 p-1 rounded-xl">
    
                    <button
                        @click="tabPilihan = 'standar'"
                        :class="tabPilihan === 'standar'
                            ? 'bg-white dark:bg-slate-700 text-slate-900 dark:text-white shadow-sm'
                            : 'text-slate-600 hover:text-slate-900 dark:text-slate-300 dark:hover:text-white hover:bg-slate-200 dark:hover:bg-slate-700'"
                        class="px-3.5 py-1.5 text-xs font-semibold rounded-lg transition-all duration-150">
                        Pengajuan Standar ({{ $pengajuanNormal->total() }})
                    </button>

                    <button
                        @click="tabPilihan = 'khusus'"
                        :class="tabPilihan === 'khusus'
                            ? 'bg-white dark:bg-slate-700 text-slate-900 dark:text-white shadow-sm'
                            : 'text-slate-600 hover:text-slate-900 dark:text-slate-300 dark:hover:text-white hover:bg-slate-200 dark:hover:bg-slate-700'"
                        class="px-3.5 py-1.5 text-xs font-semibold rounded-lg transition-all duration-150 flex items-center gap-1.5">
                        Pengajuan Khusus ({{ $pengajuanKhusus->total() }})

                        @if($pengajuanKhusus->getCollection()->where('status_approval', 'Menunggu')->count() > 0)
                            <span class="w-2 h-2 rounded-full bg-red-500 animate-pulse"></span>
                        @endif
                    </button>

                </div>
            </div>

            <!-- TAB PENGAJUAN STANDAR -->
            <div x-show="tabPilihan === 'standar'">
                @if($pengajuanNormal->isEmpty())
                    <div class="py-16 text-center">
                        <div class="w-14 h-14 bg-slate-100 dark:bg-slate-800 rounded-2xl flex items-center justify-center mx-auto mb-4">
                            <svg class="w-7 h-7 text-slate-400 dark:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2" />
                            </svg>
                        </div>
                        <div class="text-slate-600 dark:text-slate-400 font-semibold text-sm mb-1">Belum Ada Pengajuan Standar</div>
                        <div class="text-slate-400 dark:text-slate-600 text-xs">Pengajuan dana standar akan muncul di sini</div>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="border-b border-slate-100 dark:border-slate-800 bg-slate-50 dark:bg-slate-900/50">
                                    <th class="text-left text-xs text-slate-400 font-semibold uppercase tracking-wider px-5 py-3.5">Laporan</th>
                                    <th class="text-left text-xs text-slate-400 font-semibold uppercase tracking-wider px-5 py-3.5 hidden md:table-cell">Daerah</th>
                                    <th class="text-left text-xs text-slate-400 font-semibold uppercase tracking-wider px-5 py-3.5 hidden lg:table-cell">Diajukan Oleh</th>
                                    <th class="text-right text-xs text-slate-400 font-semibold uppercase tracking-wider px-5 py-3.5">Nominal</th>
                                    <th class="text-left text-xs text-slate-400 font-semibold uppercase tracking-wider px-5 py-3.5">Status</th>
                                    <th class="text-left text-xs text-slate-400 font-semibold uppercase tracking-wider px-5 py-3.5 hidden sm:table-cell">Waktu</th>
                                    <th class="px-5 py-3.5 text-xs text-slate-400 font-semibold uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                                @foreach($pengajuanNormal as $pengajuan)
                                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/40 transition">
                                        <td class="px-5 py-4">
                                            <a href="{{ route('admin.laporan.detail', $pengajuan->laporanInfrastruktur->id ?? '#') }}"
                                                class="font-mono text-xs text-brand-600 dark:text-brand-400 font-bold bg-brand-50 dark:bg-brand-900/30 px-2 py-1 rounded-lg hover:bg-brand-100 dark:hover:bg-brand-900/50 transition">
                                                {{ $pengajuan->laporanInfrastruktur->tracking_id ?? 'N/A' }}
                                            </a>
                                        </td>
                                        <td class="px-5 py-4 hidden md:table-cell">
                                            <div class="text-sm text-slate-700 dark:text-slate-300 font-medium">{{ $pengajuan->laporanInfrastruktur->daerah->nama_daerah ?? '-' }}</div>
                                            <div class="text-xs text-slate-400 dark:text-slate-600">{{ $pengajuan->laporanInfrastruktur->daerah->tingkat ?? '' }}</div>
                                        </td>
                                        <td class="px-5 py-4 hidden lg:table-cell">
                                            <div class="text-sm text-slate-700 dark:text-slate-300">{{ $pengajuan->pengguna->nama ?? '-' }}</div>
                                            <div class="text-xs text-slate-400">{{ $pengajuan->pengguna->role ?? '' }}</div>
                                        </td>
                                        <td class="px-5 py-4 text-right">
                                            <div class="text-sm font-bold text-slate-800 dark:text-white">Rp {{ number_format($pengajuan->nominal_diajukan, 0, ',', '.') }}</div>
                                            @if($pengajuan->catatan_approval)
                                                <div class="text-[11px] text-slate-400 dark:text-slate-500 mt-1 italic max-w-xs truncate" title="{{ $pengajuan->catatan_approval }}">
                                                    Catatan: "{{ $pengajuan->catatan_approval }}"
                                                </div>
                                            @endif
                                        </td>
                                        <td class="px-5 py-4">
                                            @if($pengajuan->status_approval === 'Menunggu')
                                                <span class="inline-flex items-center gap-1.5 text-xs font-semibold px-2.5 py-1 rounded-full bg-amber-50 dark:bg-amber-900/20 text-amber-600 dark:text-amber-400 border border-amber-100 dark:border-amber-800/50">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-400 animate-pulse"></span>Menunggu
                                                </span>
                                            @elseif($pengajuan->status_approval === 'Disetujui')
                                                <span class="inline-flex items-center gap-1.5 text-xs font-semibold px-2.5 py-1 rounded-full bg-emerald-50 dark:bg-emerald-900/20 text-emerald-600 dark:text-emerald-400 border border-emerald-100 dark:border-emerald-800/50">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>Disetujui
                                                </span>
                                            @else
                                                <span class="inline-flex items-center gap-1.5 text-xs font-semibold px-2.5 py-1 rounded-full bg-red-50 dark:bg-red-900/20 text-red-600 dark:text-red-400 border border-red-100 dark:border-red-800/50">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-red-400"></span>Ditolak
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-5 py-4 hidden sm:table-cell">
                                            <div class="text-xs text-slate-500 dark:text-slate-400">{{ $pengajuan->waktu_pengajuan ? \Carbon\Carbon::parse($pengajuan->waktu_pengajuan)->translatedFormat('d M Y') : '-' }}</div>
                                            <div class="text-xs text-slate-400 dark:text-slate-600">{{ $pengajuan->waktu_pengajuan ? \Carbon\Carbon::parse($pengajuan->waktu_pengajuan)->translatedFormat('H:i') . ' WIB' : '' }}</div>
                                        </td>
                                        <td class="px-5 py-4">
                                            @if($pengajuan->status_approval === 'Menunggu')
                                                <div class="flex items-center gap-2">
                                                    <button type="button" @click="idPengajuan = {{ $pengajuan->id }}; nominalPengajuan = {{ $pengajuan->nominal_diajukan }}; statusKeputusan = 'Disetujui'; modalTerbuka = true"
                                                        class="text-xs font-semibold text-emerald-700 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-900/30 hover:bg-emerald-100 dark:hover:bg-emerald-900/50 border border-emerald-200 dark:border-emerald-800/50 px-3 py-1.5 rounded-xl transition whitespace-nowrap">✓ Setujui</button>
                                                    <button type="button" @click="idPengajuan = {{ $pengajuan->id }}; nominalPengajuan = {{ $pengajuan->nominal_diajukan }}; statusKeputusan = 'Ditolak'; modalTerbuka = true"
                                                        class="text-xs font-semibold text-red-600 dark:text-red-400 bg-red-50 dark:bg-red-900/30 hover:bg-red-100 dark:hover:bg-red-900/50 border border-red-200 dark:border-red-800/50 px-3 py-1.5 rounded-xl transition whitespace-nowrap">✗ Tolak</button>
                                                </div>
                                            @else
                                                <span class="text-xs text-slate-400 dark:text-slate-600 italic">Selesai</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    @if($pengajuanNormal->hasPages())
                        <div class="px-5 py-4 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between">
                            <div class="text-xs text-slate-400">Menampilkan {{ $pengajuanNormal->firstItem() }}–{{ $pengajuanNormal->lastItem() }} dari {{ $pengajuanNormal->total() }}</div>
                            <div class="flex items-center gap-1.5">
                                @if($pengajuanNormal->onFirstPage())
                                    <span class="px-3 py-1.5 text-xs text-slate-300 dark:text-slate-700 bg-slate-100 dark:bg-slate-800 rounded-xl cursor-not-allowed">← Prev</span>
                                @else
                                    <a href="{{ $pengajuanNormal->appends(request()->except('page_normal'))->previousPageUrl() }}"
                                        class="px-3 py-1.5 text-xs text-slate-500 hover:text-slate-700 bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 rounded-xl transition">← Prev</a>
                                @endif
                                @if($pengajuanNormal->hasMorePages())
                                    <a href="{{ $pengajuanNormal->appends(request()->except('page_normal'))->nextPageUrl() }}"
                                        class="px-3 py-1.5 text-xs text-slate-500 hover:text-slate-700 bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 rounded-xl transition">Next →</a>
                                @else
                                    <span class="px-3 py-1.5 text-xs text-slate-300 dark:text-slate-700 bg-slate-100 dark:bg-slate-800 rounded-xl cursor-not-allowed">Next →</span>
                                @endif
                            </div>
                        </div>
                    @endif
                @endif
            </div>

            <!-- TAB PENGAJUAN KHUSUS -->
            <div x-show="tabPilihan === 'khusus'" style="display: none;">
                @if($pengajuanKhusus->isEmpty())
                    <div class="py-16 text-center">
                        <div class="w-14 h-14 bg-slate-100 dark:bg-slate-800 rounded-2xl flex items-center justify-center mx-auto mb-4">
                            <svg class="w-7 h-7 text-slate-400 dark:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2" />
                            </svg>
                        </div>
                        <div class="text-slate-600 dark:text-slate-400 font-semibold text-sm mb-1">Belum Ada Pengajuan Khusus</div>
                        <div class="text-slate-400 dark:text-slate-600 text-xs">Pengajuan khusus yang melebihi estimasi AI akan muncul di sini</div>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="border-b border-slate-100 dark:border-slate-800 bg-slate-50 dark:bg-slate-900/50">
                                    <th class="text-left text-xs text-slate-400 font-semibold uppercase tracking-wider px-5 py-3.5">Laporan</th>
                                    <th class="text-left text-xs text-slate-400 font-semibold uppercase tracking-wider px-5 py-3.5 hidden md:table-cell">Daerah</th>
                                    <th class="text-left text-xs text-slate-400 font-semibold uppercase tracking-wider px-5 py-3.5 hidden lg:table-cell">Diajukan Oleh</th>
                                    <th class="text-right text-xs text-slate-400 font-semibold uppercase tracking-wider px-5 py-3.5">Estimasi AI</th>
                                    <th class="text-right text-xs text-slate-400 font-semibold uppercase tracking-wider px-5 py-3.5">Nominal Diajukan</th>
                                    <th class="text-right text-xs text-slate-400 font-semibold uppercase tracking-wider px-5 py-3.5">Selisih (Kelebihan)</th>
                                    <th class="text-left text-xs text-slate-400 font-semibold uppercase tracking-wider px-5 py-3.5">Status</th>
                                    <th class="text-left text-xs text-slate-400 font-semibold uppercase tracking-wider px-5 py-3.5 hidden sm:table-cell">Waktu</th>
                                    <th class="px-5 py-3.5 text-xs text-slate-400 font-semibold uppercase tracking-wider font-medium">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                                @foreach($pengajuanKhusus as $pengajuan)
                                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/40 transition">
                                        <td class="px-5 py-4">
                                            <a href="{{ route('admin.laporan.detail', $pengajuan->laporanInfrastruktur->id ?? '#') }}"
                                                class="font-mono text-xs text-brand-600 dark:text-brand-400 font-bold bg-brand-50 dark:bg-brand-900/30 px-2 py-1 rounded-lg hover:bg-brand-100 dark:hover:bg-brand-900/50 transition">
                                                {{ $pengajuan->laporanInfrastruktur->tracking_id ?? 'N/A' }}
                                            </a>
                                        </td>
                                        <td class="px-5 py-4 hidden md:table-cell">
                                            <div class="text-sm text-slate-700 dark:text-slate-300 font-medium">{{ $pengajuan->laporanInfrastruktur->daerah->nama_daerah ?? '-' }}</div>
                                            <div class="text-xs text-slate-400 dark:text-slate-600">{{ $pengajuan->laporanInfrastruktur->daerah->tingkat ?? '' }}</div>
                                        </td>
                                        <td class="px-5 py-4 hidden lg:table-cell">
                                            <div class="text-sm text-slate-700 dark:text-slate-300">{{ $pengajuan->pengguna->nama ?? '-' }}</div>
                                            <div class="text-xs text-slate-400">{{ $pengajuan->pengguna->role ?? '' }}</div>
                                        </td>
                                        <td class="px-5 py-4 text-right">
                                            <div class="text-sm text-slate-650 dark:text-slate-400">Rp {{ number_format($pengajuan->laporanInfrastruktur->analisisAi->estimasi_biaya ?? 0, 0, ',', '.') }}</div>
                                        </td>
                                        <td class="px-5 py-4 text-right font-semibold">
                                            <div class="text-sm text-slate-800 dark:text-white">Rp {{ number_format($pengajuan->nominal_diajukan, 0, ',', '.') }}</div>
                                            @if($pengajuan->catatan_approval)
                                                <div class="text-[11px] text-slate-400 dark:text-slate-500 mt-1 italic max-w-xs truncate" title="{{ $pengajuan->catatan_approval }}">
                                                    Catatan: "{{ $pengajuan->catatan_approval }}"
                                                </div>
                                            @endif
                                        </td>
                                        <td class="px-5 py-4 text-right font-medium">
                                            @php
                                                $selisih = $pengajuan->nominal_diajukan - ($pengajuan->laporanInfrastruktur->analisisAi->estimasi_biaya ?? 0);
                                            @endphp
                                            <div class="text-sm font-bold text-red-500">+Rp {{ number_format($selisih, 0, ',', '.') }}</div>
                                        </td>
                                        <td class="px-5 py-4">
                                            @if($pengajuan->status_approval === 'Menunggu')
                                                <span class="inline-flex items-center gap-1.5 text-xs font-semibold px-2.5 py-1 rounded-full bg-red-50 dark:bg-red-950 text-red-600 dark:text-red-400 border border-red-100 dark:border-red-900/50">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-red-500 animate-pulse"></span>Tahap Lebih
                                                </span>
                                            @elseif($pengajuan->status_approval === 'Disetujui')
                                                <span class="inline-flex items-center gap-1.5 text-xs font-semibold px-2.5 py-1 rounded-full bg-emerald-50 dark:bg-emerald-900/20 text-emerald-600 dark:text-emerald-400 border border-emerald-100 dark:border-emerald-800/50">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>Disetujui
                                                </span>
                                            @else
                                                <span class="inline-flex items-center gap-1.5 text-xs font-semibold px-2.5 py-1 rounded-full bg-red-50 dark:bg-red-900/20 text-red-600 dark:text-red-400 border border-red-100 dark:border-red-800/50">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-red-400"></span>Ditolak
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-5 py-4 hidden sm:table-cell">
                                            <div class="text-xs text-slate-500 dark:text-slate-400">{{ $pengajuan->waktu_pengajuan ? \Carbon\Carbon::parse($pengajuan->waktu_pengajuan)->translatedFormat('d M Y') : '-' }}</div>
                                            <div class="text-xs text-slate-400 dark:text-slate-600">{{ $pengajuan->waktu_pengajuan ? \Carbon\Carbon::parse($pengajuan->waktu_pengajuan)->translatedFormat('H:i') . ' WIB' : '' }}</div>
                                        </td>
                                        <td class="px-5 py-4">
                                            @if($pengajuan->status_approval === 'Menunggu')
                                                <div class="flex items-center gap-2">
                                                    <button type="button" @click="idPengajuan = {{ $pengajuan->id }}; nominalPengajuan = {{ $pengajuan->nominal_diajukan }}; statusKeputusan = 'Disetujui'; modalTerbuka = true"
                                                        class="text-xs font-semibold text-emerald-700 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-900/30 hover:bg-emerald-100 dark:hover:bg-emerald-900/50 border border-emerald-200 dark:border-emerald-800/50 px-3 py-1.5 rounded-xl transition whitespace-nowrap">✓ Setujui</button>
                                                    <button type="button" @click="idPengajuan = {{ $pengajuan->id }}; nominalPengajuan = {{ $pengajuan->nominal_diajukan }}; statusKeputusan = 'Ditolak'; modalTerbuka = true"
                                                        class="text-xs font-semibold text-red-600 dark:text-red-400 bg-red-50 dark:bg-red-900/30 hover:bg-red-100 dark:hover:bg-red-900/50 border border-red-200 dark:border-red-800/50 px-3 py-1.5 rounded-xl transition whitespace-nowrap">✗ Tolak</button>
                                                </div>
                                            @else
                                                <span class="text-xs text-slate-400 dark:text-slate-600 italic">Selesai</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    @if($pengajuanKhusus->hasPages())
                        <div class="px-5 py-4 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between">
                            <div class="text-xs text-slate-400">Menampilkan {{ $pengajuanKhusus->firstItem() }}–{{ $pengajuanKhusus->lastItem() }} dari {{ $pengajuanKhusus->total() }}</div>
                            <div class="flex items-center gap-1.5">
                                @if($pengajuanKhusus->onFirstPage())
                                    <span class="px-3 py-1.5 text-xs text-slate-300 dark:text-slate-700 bg-slate-100 dark:bg-slate-800 rounded-xl cursor-not-allowed">← Prev</span>
                                @else
                                    <a href="{{ $pengajuanKhusus->appends(request()->except('page_khusus'))->previousPageUrl() }}"
                                        class="px-3 py-1.5 text-xs text-slate-500 hover:text-slate-700 bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 rounded-xl transition">← Prev</a>
                                @endif
                                @if($pengajuanKhusus->hasMorePages())
                                    <a href="{{ $pengajuanKhusus->appends(request()->except('page_khusus'))->nextPageUrl() }}"
                                        class="px-3 py-1.5 text-xs text-slate-500 hover:text-slate-700 bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 rounded-xl transition">Next →</a>
                                @else
                                    <span class="px-3 py-1.5 text-xs text-slate-300 dark:text-slate-700 bg-slate-100 dark:bg-slate-800 rounded-xl cursor-not-allowed">Next →</span>
                                @endif
                            </div>
                        </div>
                    @endif
                @endif
            </div>

            <!-- MODAL PERSETUJUAN DENGAN CATATAN -->
            <div x-show="modalTerbuka" 
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0" 
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-150" 
                x-transition:leave-start="opacity-100" 
                x-transition:leave-end="opacity-0"
                class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 backdrop-blur-sm"
                style="display: none;" 
                @click.self="modalTerbuka = false">
                <div x-show="modalTerbuka" 
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 scale-95" 
                    x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="opacity-100 scale-100" 
                    x-transition:leave-end="opacity-0 scale-95"
                    class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-6 w-full max-w-md mx-4 shadow-2xl relative z-50">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-base font-bold text-slate-800 dark:text-white" 
                            x-text="statusKeputusan === 'Disetujui' ? 'Setujui Pengajuan Dana' : 'Tolak Pengajuan Dana'"></h3>
                        <button @click="modalTerbuka = false" class="text-slate-400 hover:text-slate-600 dark:hover:text-white transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                    <form :action="'/admin/pengajuan/' + idPengajuan + '/proses-audit'" method="POST">
                        @csrf
                        <input type="hidden" name="keputusan" :value="statusKeputusan">
                        
                        <div class="mb-4">
                            <div class="text-xs text-slate-500 dark:text-slate-400 mb-3 bg-slate-50 dark:bg-slate-800 p-2.5 rounded-xl border border-slate-100 dark:border-slate-700/50">
                                Nominal Pengajuan: <span class="font-extrabold text-slate-800 dark:text-white" x-text="'Rp ' + new Intl.NumberFormat('id-ID').format(nominalPengajuan)"></span>
                            </div>
                            <label class="block text-xs text-slate-650 dark:text-slate-400 font-semibold mb-2">
                                Catatan Verifikasi <span x-show="statusKeputusan === 'Ditolak'" class="text-red-500">*</span>
                            </label>
                            <textarea name="catatan_approval" 
                                class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-white text-sm rounded-xl p-3 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent transition"
                                rows="4" 
                                placeholder="Tuliskan catatan atau alasan keputusan..."
                                :required="statusKeputusan === 'Ditolak'"></textarea>
                        </div>
                        
                        <div class="flex gap-2">
                            <button type="button" @click="modalTerbuka = false" 
                                class="flex-1 bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-600 dark:text-slate-300 font-semibold text-sm py-2.5 rounded-xl transition">
                                Batal
                            </button>
                            <button type="submit" 
                                :class="statusKeputusan === 'Disetujui' ? 'bg-emerald-600 hover:bg-emerald-500' : 'bg-red-600 hover:bg-red-500'"
                                class="flex-1 text-white font-bold text-sm py-2.5 rounded-xl transition">
                                Kirim Keputusan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- ========================================================= -->
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const isDark = document.documentElement.classList.contains('dark');
            const textColor = isDark ? '#94a3b8' : '#64748b';

            Chart.defaults.color = textColor;
            Chart.defaults.font.family = "'Outfit', sans-serif";

            const financeCtx = document.getElementById('financeChart').getContext('2d');
            new Chart(financeCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Disetujui', 'Menunggu', 'Ditolak'],
                    datasets: [{
                        data: [
                        {{ $danaDisetujui }},
                        {{ $danaMenunggu }},
                            {{ $danaDitolak }}
                        ],
                        backgroundColor: ['#10b981', '#f59e0b', '#ef4444'],
                        hoverOffset: 4,
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '70%',
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 20,
                                usePointStyle: true,
                                pointStyle: 'circle'
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function (context) {
                                    let label = context.label || '';
                                    if (label) {
                                        label += ': ';
                                    }
                                    if (context.parsed !== null) {
                                        label += new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(context.parsed);
                                    }
                                    return label;
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
@endsection