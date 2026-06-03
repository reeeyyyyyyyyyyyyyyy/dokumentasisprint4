<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekapitulasi Laporan SIGAP BDG - {{ now()->format('d/m/Y') }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Outfit', sans-serif;
        }

        @media print {
            body {
                background: #white;
                color: #000;
                padding: 1.5cm;
            }

            .no-print {
                display: none !important;
            }

            .page-break-avoid {
                page-break-inside: avoid;
            }
        }
    </style>
</head>

<body class="bg-slate-100 text-slate-800 p-8 min-h-screen flex flex-col items-center">
    <!-- ========================================================= -->
    <!-- SPRINT 4 - FEATURE 2: Ekspor Laporan [Dev 2] -->
    <!-- ========================================================= -->
    <div
        class="no-print w-full max-w-4xl bg-blue-50 border border-blue-200 text-blue-800 rounded-2xl p-4 mb-6 text-sm flex items-center justify-between shadow-sm">
        <div>
            <span class="font-bold">Mode Pratinjau Cetak PDF.</span> Halaman ini secara otomatis memicu dialog cetak
            browser Anda. Jika dialog tidak muncul, silakan klik tombol di sebelah kanan.
        </div>
        <button onclick="window.print()"
            class="bg-brand-600 hover:bg-brand-500 text-white font-bold px-4 py-2 rounded-xl text-xs transition">
            Cetak Ulang
        </button>
    </div>

    <div class="bg-white border border-slate-200 rounded-2xl w-full max-w-4xl p-10 shadow-sm relative flex-grow">
        <!-- Kop Surat Resmi -->
        <div class="border-b-4 border-double border-slate-850 pb-5 mb-6 flex items-center gap-6">
            <img src="https://upload.wikimedia.org/wikipedia/commons/e/e8/Lambang_Kota_Bandung.svg"
                alt="Logo Kota Bandung" class="w-20 h-20 object-contain">
            <div class="flex-grow text-center pr-10">
                <h1 class="text-xl font-bold uppercase tracking-wider text-slate-900 leading-tight">Pemerintah Kota
                    Bandung</h1>
                <h2 class="text-lg font-semibold uppercase tracking-wide text-slate-700 leading-tight">Dinas Komunikasi
                    dan Informatika</h2>
                <p class="text-xs text-slate-500 mt-1.5 leading-normal">
                    Kompleks Balai Kota Bandung, Jl. Wastukencana No.2, Babakan Ciamis, Kec. Sumur Bandung, Kota
                    Bandung, Jawa Barat 40117 <br>
                    Telepon: (022) 4203712 · Surat Elektronik: diskominfo@bandung.go.id
                </p>
            </div>
        </div>

        <div class="text-center mb-8">
            <h3 class="text-base font-extrabold uppercase tracking-widest text-slate-900">Laporan Rekapitulasi
                Penanganan Krisis & Infrastruktur</h3>
            <p class="text-xs text-slate-500 mt-1 font-semibold">Sistem Informasi Gawat Darurat & Pengaduan (SIGAP BDG)
            </p>
        </div>

        <div class="grid grid-cols-2 gap-4 mb-6 text-xs bg-slate-50 border border-slate-200 p-4 rounded-xl">
            <div>
                <table class="w-full">
                    <tr>
                        <td class="font-semibold text-slate-500 py-1 pr-4 w-32">Kategori Laporan</td>
                        <td class="text-slate-800 py-1 font-bold">:
                            {{ request('kategori') ? ucfirst(request('kategori')) : 'Semua' }}</td>
                    </tr>
                    <tr>
                        <td class="font-semibold text-slate-500 py-1 pr-4">Daerah/Kecamatan</td>
                        <td class="text-slate-800 py-1 font-bold">:
                            {{ request('id_daerah') ? (\App\Models\Daerah::find(request('id_daerah'))->nama_daerah ?? 'Tidak Diketahui') : 'Semua Kecamatan' }}
                        </td>
                    </tr>
                </table>
            </div>
            <div>
                <table class="w-full">
                    <tr>
                        <td class="font-semibold text-slate-500 py-1 pr-4 w-32">Periode</td>
                        <td class="text-slate-800 py-1 font-bold">:
                            @if(request('tanggal_mulai') && request('tanggal_selesai'))
                                {{ \Carbon\Carbon::parse(request('tanggal_mulai'))->translatedFormat('d F Y') }} s.d.
                                {{ \Carbon\Carbon::parse(request('tanggal_selesai'))->translatedFormat('d F Y') }}
                            @else
                                Semua Periode
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="font-semibold text-slate-500 py-1 pr-4">Status Penanganan</td>
                        <td class="text-slate-800 py-1 font-bold">:
                            {{ request('status') ? ucfirst(request('status')) : 'Semua Status' }}</td>
                    </tr>
                </table>
            </div>
        </div>

        @if($laporan->isEmpty())
            <div class="py-12 text-center text-slate-400 text-sm border border-dashed border-slate-200 rounded-xl">
                Tidak ada data laporan yang memenuhi kriteria penyaringan.
            </div>
        @else
            <table class="w-full text-xs border-collapse">
                <thead>
                    <tr class="bg-slate-100 border-t border-b border-slate-300">
                        <th class="px-3 py-3 font-bold uppercase text-left w-12 text-slate-700">No</th>
                        <th class="px-3 py-3 font-bold uppercase text-left w-28 text-slate-700">Tipe Laporan</th>
                        <th class="px-3 py-3 font-bold uppercase text-left w-32 text-slate-700">Tracking ID</th>
                        <th class="px-3 py-3 font-bold uppercase text-left text-slate-700">Kecamatan</th>
                        <th class="px-3 py-3 font-bold uppercase text-left w-24 text-slate-700">Status</th>
                        <th class="px-3 py-3 font-bold uppercase text-left w-40 text-slate-700">Waktu Masuk</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @foreach($laporan as $index => $item)
                        <tr class="page-break-avoid">
                            <td class="px-3 py-3 font-semibold text-slate-500 text-left">{{ $index + 1 }}</td>
                            <td class="px-3 py-3">
                                <span class="font-bold text-slate-900">{{ $item['tipe'] }}</span>
                            </td>
                            <td class="px-3 py-3 font-mono font-bold text-slate-700">{{ $item['tracking_id'] }}</td>
                            <td class="px-3 py-3 text-slate-800 font-medium">{{ $item['daerah'] }}</td>
                            <td class="px-3 py-3 font-bold uppercase text-slate-900">{{ $item['status'] }}</td>
                            <td class="px-3 py-3 text-slate-500">
                                {{ $item['waktu']->translatedFormat('d-m-Y') }} · {{ $item['waktu']->translatedFormat('H:i') }}
                                WIB
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

        <div class="page-break-avoid flex justify-end mt-12 text-xs">
            <div class="text-center w-64">
                <p class="text-slate-500">Bandung, {{ now()->translatedFormat('d F Y') }}</p>
                <p class="font-semibold text-slate-800 mt-1 mb-20">Petugas Administrator SIGAP</p>
                <div class="border-b border-slate-400 mx-auto w-48"></div>
                <p class="font-bold text-slate-950 mt-1 uppercase">Diskominfo Kota Bandung</p>
            </div>
        </div>
    </div>
    <!-- ========================================================= -->

    <script>
        window.onload = function () {
            setTimeout(function () {
                window.print();
            }, 500);
        };
    </script>
</body>

</html>