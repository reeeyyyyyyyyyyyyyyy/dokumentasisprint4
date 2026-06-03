@extends('admin.layout')

@section('judulHalaman', 'Ekspor Laporan')
@section('subjudulHalaman', 'Saring pratinjau data dan unduh rekapitulasi laporan resmi')

@section('konten')
    <!-- ========================================================= -->
    <!-- SPRINT 4 - FEATURE 2: Ekspor Laporan [Dev 2] -->
    <!-- ========================================================= -->
    <div class="space-y-5">
        <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-5 shadow-sm">
            <div class="text-sm font-bold text-slate-800 dark:text-white mb-4">Filter Data Laporan</div>
            @if(Auth::user()->role === 'Super Admin')
            <form action="{{ route('admin.ekspor.indeks') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
            @else
            <form action="{{ route('admin.ekspor.indeks') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            @endif
                <div>
                    <label class="block text-xs text-slate-500 dark:text-slate-400 font-semibold mb-2">Tanggal Mulai</label>
                    <input type="date" name="tanggal_mulai" value="{{ request('tanggal_mulai') }}" 
                        class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-white text-xs rounded-xl px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-brand-500 transition">
                </div>
                <div>
                    <label class="block text-xs text-slate-500 dark:text-slate-400 font-semibold mb-2">Tanggal Selesai</label>
                    <input type="date" name="tanggal_selesai" value="{{ request('tanggal_selesai') }}" 
                        class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-white text-xs rounded-xl px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-brand-500 transition">
                </div>
                @if(Auth::user()->role === 'Super Admin')
                <div>
                    <label class="block text-xs text-slate-500 dark:text-slate-400 font-semibold mb-2">Kecamatan</label>
                    <select name="id_daerah" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-white text-xs rounded-xl px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-brand-500 transition">
                        <option value="">Semua Kecamatan</option>
                        @foreach($daftarDaerah as $daerah)
                            <option value="{{ $daerah->id }}" {{ request('id_daerah') == $daerah->id ? 'selected' : '' }}>
                                {{ $daerah->nama_daerah }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @endif
                <div>
                    <label class="block text-xs text-slate-500 dark:text-slate-400 font-semibold mb-2">Kategori Laporan</label>
                    <select name="kategori" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-white text-xs rounded-xl px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-brand-500 transition">
                        <option value="semua" {{ request('kategori') == 'semua' ? 'selected' : '' }}>Semua Kategori</option>
                        <option value="infrastruktur" {{ request('kategori') == 'infrastruktur' ? 'selected' : '' }}>Infrastruktur</option>
                        <option value="kejahatan" {{ request('kategori') == 'kejahatan' ? 'selected' : '' }}>Kejahatan</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs text-slate-500 dark:text-slate-400 font-semibold mb-2">Status</label>
                    <select name="status" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-white text-xs rounded-xl px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-brand-500 transition">
                        <option value="semua" {{ request('status') == 'semua' ? 'selected' : '' }}>Semua Status</option>
                        <option value="Menunggu" {{ request('status') == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                        <option value="Proses" {{ request('status') == 'Proses' ? 'selected' : '' }}>Proses</option>
                        <option value="Selesai" {{ request('status') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                        <option value="Ditolak" {{ request('status') == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                </div>
                @if(Auth::user()->role === 'Super Admin')
                <div class="lg:col-span-5 flex justify-end gap-2 pt-2 border-t border-slate-100 dark:border-slate-800 col-span-1 sm:col-span-2 lg:col-span-5">
                @else
                <div class="lg:col-span-4 flex justify-end gap-2 pt-2 border-t border-slate-100 dark:border-slate-800 col-span-1 sm:col-span-2 lg:col-span-4">
                @endif
                    <a href="{{ route('admin.ekspor.indeks') }}" 
                        class="bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-650 dark:text-slate-300 text-xs font-semibold px-4 py-2 rounded-xl transition flex items-center justify-center">
                        Reset Filter
                    </a>
                    <button type="submit" 
                        class="bg-brand-600 hover:bg-brand-500 text-white text-xs font-bold px-5 py-2.5 rounded-xl transition flex items-center justify-center gap-1.5">
                        Terapkan Filter
                    </button>
                </div>
            </form>
        </div>

        <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl overflow-hidden shadow-sm">
            <div class="px-5 py-4 border-b border-slate-100 dark:border-slate-800 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 bg-slate-50/50 dark:bg-slate-900/50">
                <div>
                    <div class="text-sm font-bold text-slate-800 dark:text-white">Pratinjau Data Rekapitulasi</div>
                    <div class="text-xs text-slate-400 mt-0.5">Ditemukan {{ $laporanTerfilter->total() }} baris data</div>
                </div>
                <div class="flex items-center gap-2">
                    <a href="{{ route('admin.ekspor.csv', request()->query()) }}" 
                        class="text-xs font-bold text-emerald-700 dark:text-emerald-450 bg-emerald-50 dark:bg-emerald-950/20 hover:bg-emerald-100 dark:hover:bg-emerald-900/50 border border-emerald-200 dark:border-emerald-900/30 px-3.5 py-2 rounded-xl transition flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        Unduh CSV (Excel)
                    </a>
                    <a href="{{ route('admin.ekspor.pdf', request()->query()) }}" target="_blank" 
                        class="text-xs font-bold text-red-650 dark:text-red-400 bg-red-50 dark:bg-red-950/20 hover:bg-red-100 dark:hover:bg-red-900/50 border border-red-200 dark:border-red-900/30 px-3.5 py-2 rounded-xl transition flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                        Cetak PDF
                    </a>
                </div>
            </div>

            @if($laporanTerfilter->isEmpty())
                <div class="py-16 text-center">
                    <div class="w-14 h-14 bg-slate-100 dark:bg-slate-800 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <svg class="w-7 h-7 text-slate-400 dark:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2" />
                        </svg>
                    </div>
                    <div class="text-slate-650 dark:text-slate-400 font-semibold text-sm mb-1">Tidak Ada Data Ditemukan</div>
                    <div class="text-slate-400 dark:text-slate-600 text-xs">Sesuaikan filter pencarian Anda dan coba lagi</div>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b border-slate-100 dark:border-slate-800 bg-slate-50 dark:bg-slate-900/50">
                                <th class="text-left text-xs text-slate-400 font-semibold uppercase tracking-wider px-5 py-3.5">No</th>
                                <th class="text-left text-xs text-slate-400 font-semibold uppercase tracking-wider px-5 py-3.5">Tipe Laporan</th>
                                <th class="text-left text-xs text-slate-400 font-semibold uppercase tracking-wider px-5 py-3.5">Tracking ID</th>
                                <th class="text-left text-xs text-slate-400 font-semibold uppercase tracking-wider px-5 py-3.5">Daerah</th>
                                <th class="text-left text-xs text-slate-400 font-semibold uppercase tracking-wider px-5 py-3.5">Status</th>
                                <th class="text-left text-xs text-slate-400 font-semibold uppercase tracking-wider px-5 py-3.5">Waktu</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                            @foreach($laporanTerfilter as $index => $item)
                                <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/40 transition">
                                    <td class="px-5 py-4 text-xs font-semibold text-slate-500">
                                        {{ $laporanTerfilter->firstItem() + $index }}
                                    </td>
                                    <td class="px-5 py-4">
                                        <span class="inline-flex items-center text-xs font-bold px-2 py-1 rounded-lg {{ $item['tipe'] === 'Infrastruktur' ? 'bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-455' : 'bg-red-50 dark:bg-red-900/20 text-red-650 dark:text-red-400' }}">
                                            {{ $item['tipe'] }}
                                        </span>
                                    </td>
                                    <td class="px-5 py-4 font-mono text-xs text-slate-700 dark:text-slate-300 font-bold">
                                        {{ $item['tracking_id'] }}
                                    </td>
                                    <td class="px-5 py-4 text-slate-700 dark:text-slate-300 font-medium">
                                        {{ $item['daerah'] }}
                                    </td>
                                    <td class="px-5 py-4">
                                        @if($item['status'] === 'Menunggu')
                                            <span class="inline-flex items-center gap-1 text-xs font-semibold px-2 py-0.5 rounded-full bg-amber-50 dark:bg-amber-900/20 text-amber-600 dark:text-amber-400 border border-amber-100 dark:border-amber-800/50">
                                                <span class="w-1.5 h-1.5 rounded-full bg-amber-400"></span>Menunggu
                                            </span>
                                        @elseif($item['status'] === 'Proses')
                                            <span class="inline-flex items-center gap-1 text-xs font-semibold px-2 py-0.5 rounded-full bg-brand-50 dark:bg-brand-900/20 text-brand-600 dark:text-brand-400 border border-brand-100 dark:border-brand-800/50">
                                                <span class="w-1.5 h-1.5 rounded-full bg-brand-400"></span>Proses
                                            </span>
                                        @elseif($item['status'] === 'Selesai')
                                            <span class="inline-flex items-center gap-1 text-xs font-semibold px-2 py-0.5 rounded-full bg-emerald-50 dark:bg-emerald-900/20 text-emerald-600 dark:text-emerald-400 border border-emerald-100 dark:border-emerald-800/50">
                                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>Selesai
                                            </span>
                                        @elseif($item['status'] === 'Ditolak')
                                            <span class="inline-flex items-center gap-1 text-xs font-semibold px-2 py-0.5 rounded-full bg-red-50 dark:bg-red-900/20 text-red-600 dark:text-red-400 border border-red-100 dark:border-red-800/50">
                                                <span class="w-1.5 h-1.5 rounded-full bg-red-400"></span>Ditolak
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 text-xs font-semibold px-2 py-0.5 rounded-full bg-red-50 dark:bg-red-900/20 text-red-650 dark:text-red-400 border border-red-100 dark:border-red-800/50">
                                                <span class="w-1.5 h-1.5 rounded-full bg-red-450"></span>{{ $item['status'] }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-5 py-4 text-xs text-slate-500 dark:text-slate-400">
                                        {{ $item['waktu']->translatedFormat('d F Y') }} · {{ $item['waktu']->translatedFormat('H:i') }} WIB
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if($laporanTerfilter->hasPages())
                    <div class="px-5 py-4 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between">
                        <div class="text-xs text-slate-400">Menampilkan {{ $laporanTerfilter->firstItem() }}–{{ $laporanTerfilter->lastItem() }} dari {{ $laporanTerfilter->total() }}</div>
                        <div class="flex items-center gap-1.5">
                            @if($laporanTerfilter->onFirstPage())
                                <span class="px-3 py-1.5 text-xs text-slate-300 dark:text-slate-700 bg-slate-100 dark:bg-slate-800 rounded-xl cursor-not-allowed">← Prev</span>
                            @else
                                <a href="{{ $laporanTerfilter->previousPageUrl() }}"
                                    class="px-3 py-1.5 text-xs text-slate-500 hover:text-slate-700 bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 rounded-xl transition">← Prev</a>
                            @endif
                            @if($laporanTerfilter->hasMorePages())
                                <a href="{{ $laporanTerfilter->nextPageUrl() }}"
                                    class="px-3 py-1.5 text-xs text-slate-500 hover:text-slate-700 bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 rounded-xl transition">Next →</a>
                            @else
                                <span class="px-3 py-1.5 text-xs text-slate-300 dark:text-slate-700 bg-slate-100 dark:bg-slate-800 rounded-xl cursor-not-allowed">Next →</span>
                            @endif
                        </div>
                    </div>
                @endif
            @endif
        </div>
    </div>
    <!-- ========================================================= -->
@endsection
