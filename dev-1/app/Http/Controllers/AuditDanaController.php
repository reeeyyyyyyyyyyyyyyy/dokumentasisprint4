<?php

namespace App\Http\Controllers;

// =========================================================
// SPRINT 4 - FEATURE 1: Verifikasi Dana Khusus [Dev 1]
// =========================================================

use App\Models\PengajuanDana;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuditDanaController extends Controller
{
    public function tampilkanDaftarAudit(Request $request)
    {
        if (Auth::user()->role !== 'Super Admin') {
            abort(403);
        }

        $pengajuanKhusus = PengajuanDana::with(['laporanInfrastruktur.daerah', 'laporanInfrastruktur.analisisAi', 'pengguna'])
            ->join('laporan_infrastruktur', 'pengajuan_dana.id_laporan', '=', 'laporan_infrastruktur.id')
            ->leftJoin('analisis_ai', 'laporan_infrastruktur.id', '=', 'analisis_ai.id_laporan')
            ->whereRaw('pengajuan_dana.nominal_diajukan > COALESCE(analisis_ai.estimasi_biaya, 0)')
            ->select('pengajuan_dana.*')
            ->latest('pengajuan_dana.created_at')
            ->paginate(10, ['*'], 'page_khusus');

        $pengajuanNormal = PengajuanDana::with(['laporanInfrastruktur.daerah', 'laporanInfrastruktur.analisisAi', 'pengguna'])
            ->join('laporan_infrastruktur', 'pengajuan_dana.id_laporan', '=', 'laporan_infrastruktur.id')
            ->leftJoin('analisis_ai', 'laporan_infrastruktur.id', '=', 'analisis_ai.id_laporan')
            ->where(function ($query) {
                $query->whereRaw('pengajuan_dana.nominal_diajukan <= analisis_ai.estimasi_biaya')
                    ->orWhereNull('analisis_ai.estimasi_biaya');
            })
            ->select('pengajuan_dana.*')
            ->latest('pengajuan_dana.created_at')
            ->paginate(10, ['*'], 'page_normal');

        $danaDisetujui = PengajuanDana::where('status_approval', 'Disetujui')->sum('nominal_diajukan');
        $danaDitolak = PengajuanDana::where('status_approval', 'Ditolak')->sum('nominal_diajukan');
        $danaMenunggu = PengajuanDana::where('status_approval', 'Menunggu')->sum('nominal_diajukan');

        return view('admin.keuangan.indeks', compact(
            'pengajuanKhusus',
            'pengajuanNormal',
            'danaDisetujui',
            'danaDitolak',
            'danaMenunggu'
        ));
    }

    public function prosesPersetujuanAudit(Request $request, $id)
    {
        if (Auth::user()->role !== 'Super Admin') {
            abort(403);
        }

        $request->validate([
            'keputusan' => ['required', 'in:Disetujui,Ditolak'],
            'catatan_approval' => ['nullable', 'string', 'max:1000'],
        ]);

        $dataPengajuan = PengajuanDana::findOrFail($id);
        $keputusanBaru = $request->input('keputusan');

        $dataPengajuan->update([
            'status_approval' => $keputusanBaru,
            'catatan_approval' => $request->input('catatan_approval'),
        ]);

        $pesanHasil = $keputusanBaru === 'Disetujui'
            ? 'Pengajuan dana berhasil disetujui.'
            : 'Pengajuan dana telah ditolak.';

        return redirect()
            ->route('admin.keuangan.indeks')
            ->with('sukses', $pesanHasil);
    }
}
// =========================================================
