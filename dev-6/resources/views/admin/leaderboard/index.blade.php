@extends('admin.layout')

@section('judulHalaman', 'Manajemen Poin & Daerah')
@section('subjudulHalaman', 'Pantau poin kontribusi daerah dan berikan poin bonus untuk mengapresiasi kinerja kecamatan')

@section('konten')
<!-- ========================================================= -->
<!-- SPRINT 4 - FEATURE 6: Leaderboard & Poin Daerah [Dev 6] -->
<!-- ========================================================= -->
<div class="space-y-6">

    @if(session('sukses'))
        <div class="bg-emerald-50 dark:bg-emerald-950/30 border border-emerald-200 dark:border-emerald-800 text-emerald-700 dark:text-emerald-400 p-4 rounded-xl text-xs flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            {{ session('sukses') }}
        </div>
    @endif

    <!-- Cards Summary -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
        <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-5 shadow-sm">
            <div class="text-xs text-slate-500 dark:text-slate-400 mb-1">Kecamatan Terunggul Saat Ini</div>
            <div class="text-lg font-bold text-slate-850 dark:text-white mt-1">
                {{ $topKecamatan ? $topKecamatan->nama : 'Belum Ada' }}
            </div>
            <div class="text-[10px] text-brand-600 dark:text-brand-400 font-mono mt-1 font-bold">
                {{ $topKecamatan ? number_format($topKecamatan->poin, 0, ',', '.') : 0 }} Poin Akumulasi
            </div>
        </div>

        <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-5 shadow-sm">
            <div class="text-xs text-slate-500 dark:text-slate-400 mb-1">Total Transaksi Poin</div>
            <div class="text-lg font-bold text-slate-850 dark:text-white mt-1">
                {{ number_format($riwayatPoin->total(), 0, ',', '.') }} Transaksi
            </div>
            <div class="text-[10px] text-slate-400 mt-1">
                Dicatat otomatis sejak modul diaktifkan
            </div>
        </div>

        <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-5 shadow-sm">
            <div class="text-xs text-slate-500 dark:text-slate-400 mb-1">Sistem Reward & Apresiasi</div>
            <div class="text-lg font-bold text-emerald-600 dark:text-emerald-400 mt-1">
                Aktif & Real-time
            </div>
            <div class="text-[10px] text-slate-400 mt-1">
                Poin mendorong kompetisi positif kecamatan
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Form Poin Bonus (Hanya Super Admin) -->
        <div class="lg:col-span-1">
            <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-5 shadow-sm">
                <div class="text-sm font-bold text-slate-850 dark:text-white mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Apresiasi Poin Bonus
                </div>

                @if(Auth::user()->role === 'Super Admin')
                    <form action="{{ route('admin.leaderboard.bonus') }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label for="id_daerah" class="block text-xs text-slate-600 dark:text-slate-400 font-semibold mb-2">Pilih Kecamatan</label>
                            <select name="id_daerah" id="id_daerah" required class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-white text-xs rounded-xl px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-brand-500 transition">
                                <option value="">Pilih Kecamatan...</option>
                                @foreach($daftarDaerah as $daerah)
                                    <option value="{{ $daerah->id }}">{{ $daerah->nama_daerah }}</option>
                                @endforeach
                            </select>
                            @error('id_daerah')
                                <p class="text-[10px] text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="poin" class="block text-xs text-slate-600 dark:text-slate-400 font-semibold mb-2">Jumlah Poin Bonus</label>
                            <input type="number" name="poin" id="poin" min="1" max="500" required placeholder="Contoh: 100" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-white text-xs rounded-xl px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-brand-500 transition">
                            @error('poin')
                                <p class="text-[10px] text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="deskripsi" class="block text-xs text-slate-600 dark:text-slate-400 font-semibold mb-2">Alasan Penghargaan / Deskripsi</label>
                            <textarea name="deskripsi" id="deskripsi" rows="3" required placeholder="Contoh: Apresiasi tanggap bencana banjir mandiri di kelurahan..." class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-white text-xs rounded-xl px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-brand-500 transition resize-none"></textarea>
                            @error('deskripsi')
                                <p class="text-[10px] text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit" class="w-full bg-brand-600 hover:bg-brand-500 text-white font-bold text-xs py-2.5 rounded-xl transition shadow-md shadow-brand-500/10 active:scale-95 flex items-center justify-center gap-1.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            Berikan Poin Bonus
                        </button>
                    </form>
                @else
                    <div class="bg-slate-50 dark:bg-slate-850 border border-slate-100 dark:border-slate-800 p-4 rounded-xl text-center">
                        <svg class="w-8 h-8 text-slate-400 dark:text-slate-600 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                        <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed">
                            Formulir pemberian poin bonus khusus hanya dapat diakses oleh **Super Admin** Kota Bandung.
                        </p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Log Riwayat Poin (Paling Baru) -->
        <div class="lg:col-span-2">
            <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-5 shadow-sm flex flex-col h-full justify-between">
                <div>
                    <div class="text-sm font-bold text-slate-850 dark:text-white mb-4">Log Riwayat Poin Daerah</div>
                    
                    <div class="overflow-x-auto rounded-xl border border-slate-100 dark:border-slate-800">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-slate-50 dark:bg-slate-850 text-slate-500 dark:text-slate-400 text-[10px] font-bold uppercase tracking-wider border-b border-slate-100 dark:border-slate-800">
                                    <th class="px-4 py-3">Tanggal</th>
                                    <th class="px-4 py-3">Kecamatan</th>
                                    <th class="px-4 py-3">Kategori</th>
                                    <th class="px-4 py-3">Keterangan</th>
                                    <th class="px-4 py-3 text-right pr-4">Poin</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($riwayatPoin as $riwayat)
                                    <tr class="border-b border-slate-50 dark:border-slate-850 text-xs hover:bg-slate-50/50 dark:hover:bg-slate-800/10 transition">
                                        <td class="px-4 py-3 text-[10px] font-mono text-slate-400 dark:text-slate-500 whitespace-nowrap">
                                            {{ $riwayat->created_at->format('d/m/Y H:i') }}
                                        </td>
                                        <td class="px-4 py-3 font-bold text-slate-700 dark:text-slate-300">
                                            {{ $riwayat->daerah->nama_daerah }}
                                        </td>
                                        <td class="px-4 py-3">
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium
                                                {{ $riwayat->kategori === 'Laporan Baru' ? 'bg-indigo-50 text-indigo-700 dark:bg-indigo-900/20 dark:text-indigo-400' : '' }}
                                                {{ $riwayat->kategori === 'Respon Cepat' ? 'bg-amber-50 text-amber-700 dark:bg-amber-900/20 dark:text-amber-400' : '' }}
                                                {{ $riwayat->kategori === 'Penyelesaian' ? 'bg-emerald-50 text-emerald-700 dark:bg-emerald-900/20 dark:text-emerald-400' : '' }}
                                                {{ $riwayat->kategori === 'Ulasan Warga' ? 'bg-rose-50 text-rose-700 dark:bg-rose-900/20 dark:text-rose-400' : '' }}
                                                {{ $riwayat->kategori === 'Bonus Spesial' ? 'bg-purple-50 text-purple-700 dark:bg-purple-900/20 dark:text-purple-400' : '' }}
                                            ">
                                                {{ $riwayat->kategori }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 text-slate-500 dark:text-slate-400 max-w-[180px] truncate" title="{{ $riwayat->deskripsi }}">
                                            {{ $riwayat->deskripsi }}
                                        </td>
                                        <td class="px-4 py-3 text-right pr-4 font-bold font-mono text-brand-600 dark:text-brand-400">
                                            +{{ $riwayat->poin }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-4 py-6 text-center text-xs text-slate-400 dark:text-slate-600 italic">
                                            Belum ada pencatatan poin masuk.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="mt-4">
                    {{ $riwayatPoin->links() }}
                </div>
            </div>
        </div>
    </div>

</div>
<!-- ========================================================= -->
@endsection
