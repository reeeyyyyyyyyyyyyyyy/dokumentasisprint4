<?php

namespace App\Http\Controllers;

// =========================================================
// SPRINT 4 - FEATURE 2: Ekspor Laporan [Dev 2]
// =========================================================

use App\Models\Daerah;
use App\Models\LaporanInfrastruktur;
use App\Models\LaporanKejahatan;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class LaporanEksporController extends Controller
{
    public function indeks(Request $request)
    {
        $daftarDaerah = Daerah::all();
        $dataFilter = $this->ambilDataFilter($request);

        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 15;
        $currentItems = $dataFilter->slice(($currentPage - 1) * $perPage, $perPage)->values();
        
        $laporanTerfilter = new LengthAwarePaginator(
            $currentItems,
            $dataFilter->count(),
            $perPage,
            $currentPage,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('admin.ekspor.indeks', compact('daftarDaerah', 'laporanTerfilter'));
    }

    public function eksporCsv(Request $request)
    {
        $data = $this->ambilDataFilter($request);

        $headers = [
            'Content-type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="ekspor-laporan-' . now()->format('Ymd-His') . '.csv"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0'
        ];

        $columns = ['No', 'Tipe Laporan', 'Tracking ID', 'Daerah/Kecamatan', 'Status', 'Koordinat', 'Waktu Masuk'];

        $callback = function () use ($data, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            $no = 1;
            foreach ($data as $row) {
                fputcsv($file, [
                    $no++,
                    $row['tipe'],
                    $row['tracking_id'],
                    $row['daerah'],
                    $row['status'],
                    $row['koordinat'],
                    $row['waktu']->format('d-m-Y H:i') . ' WIB'
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function eksporPdf(Request $request)
    {
        $laporan = $this->ambilDataFilter($request);
        return view('admin.ekspor.pdf_template', compact('laporan'));
    }

    private function ambilDataFilter(Request $request)
    {
        $tanggalMulai = $request->input('tanggal_mulai');
        $tanggalSelesai = $request->input('tanggal_selesai');
        $idDaerah = auth()->user()->role === 'Super Admin'
            ? $request->input('id_daerah')
            : auth()->user()->id_daerah;
        $kategori = $request->input('kategori', 'semua');
        $status = $request->input('status', 'semua');

        $laporanInfrastruktur = collect();
        $laporanKejahatan = collect();

        if ($kategori === 'semua' || $kategori === 'infrastruktur') {
            $queryInf = LaporanInfrastruktur::with('daerah');

            if ($tanggalMulai) {
                $queryInf->where('created_at', '>=', $tanggalMulai . ' 00:00:00');
            }
            if ($tanggalSelesai) {
                $queryInf->where('created_at', '<=', $tanggalSelesai . ' 23:59:59');
            }
            if ($idDaerah) {
                $queryInf->where('id_daerah', $idDaerah);
            }
            if ($status && $status !== 'semua') {
                $queryInf->where('status', $status);
            }

            $laporanInfrastruktur = $queryInf->get()->map(function ($item) {
                return [
                    'tipe' => 'Infrastruktur',
                    'tracking_id' => $item->tracking_id,
                    'daerah' => $item->daerah->nama_daerah ?? 'Tidak Diketahui',
                    'status' => $item->status,
                    'waktu' => $item->created_at,
                    'koordinat' => $item->latitude . ', ' . $item->longitude,
                ];
            });
        }

        if (($kategori === 'semua' || $kategori === 'kejahatan') && ($status === 'semua')) {
            $queryKej = LaporanKejahatan::with('daerah');

            if ($tanggalMulai) {
                $queryKej->where('created_at', '>=', $tanggalMulai . ' 00:00:00');
            }
            if ($tanggalSelesai) {
                $queryKej->where('created_at', '<=', $tanggalSelesai . ' 23:59:59');
            }
            if ($idDaerah) {
                $queryKej->where('id_daerah', $idDaerah);
            }

            $laporanKejahatan = $queryKej->get()->map(function ($item) {
                return [
                    'tipe' => 'Kejahatan',
                    'tracking_id' => 'SOS-KJH-' . str_pad($item->id, 4, '0', STR_PAD_LEFT),
                    'daerah' => $item->daerah->nama_daerah ?? 'Tidak Diketahui',
                    'status' => 'Aktif',
                    'waktu' => $item->created_at,
                    'koordinat' => $item->latitude . ', ' . $item->longitude,
                ];
            });
        }

        return $laporanInfrastruktur->concat($laporanKejahatan)->sortByDesc('waktu');
    }
}
// =========================================================
