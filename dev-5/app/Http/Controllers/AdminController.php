<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LaporanInfrastruktur;
use App\Models\LaporanKejahatan;
use App\Models\AnalisisAi;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function tampilkanBeranda()
    {
        $penggunaAktif = Auth::user();

        $chartTrendLabels = [];
        $chartTrendData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = \Carbon\Carbon::today()->subDays($i);
            $chartTrendLabels[] = $date->format('d M');
            $query = \App\Models\LaporanInfrastruktur::whereDate('created_at', $date);
            if ($penggunaAktif->role !== 'Super Admin') {
                $query->where('id_daerah', $penggunaAktif->id_daerah);
            }
            $chartTrendData[] = $query->count();
        }

        $danaQuery = \App\Models\PengajuanDana::query();
        if ($penggunaAktif->role !== 'Super Admin') {
            $danaQuery->whereHas('laporanInfrastruktur', function ($q) use ($penggunaAktif) {
                $q->where('id_daerah', $penggunaAktif->id_daerah);
            });
        }
        $danaDisetujui = (clone $danaQuery)->where('status_approval', 'Disetujui')->sum('nominal_diajukan');
        $danaDitolak = (clone $danaQuery)->where('status_approval', 'Ditolak')->sum('nominal_diajukan');
        $danaMenunggu = (clone $danaQuery)->where('status_approval', 'Menunggu')->sum('nominal_diajukan');

        $chartRatingLabels = ['Bintang 1', 'Bintang 2', 'Bintang 3', 'Bintang 4', 'Bintang 5'];
        $chartRatingData = [0, 0, 0, 0, 0];

        $ratingQuery = \App\Models\UlasanLaporan::query();
        if ($penggunaAktif->role !== 'Super Admin') {
            $ratingQuery->whereHas('laporanInfrastruktur', function ($q) use ($penggunaAktif) {
                $q->where('id_daerah', $penggunaAktif->id_daerah);
            });
        }
        $ratings = $ratingQuery->selectRaw('rating, COUNT(*) as count')->groupBy('rating')->pluck('count', 'rating')->toArray();
        for ($i = 1; $i <= 5; $i++) {
            $chartRatingData[$i - 1] = $ratings[$i] ?? 0;
        }

        if ($penggunaAktif->role === 'Super Admin') {
            $totalLaporan = LaporanInfrastruktur::count();
            $totalMenunggu = LaporanInfrastruktur::where('status', 'Menunggu')->count();
            $totalProses = LaporanInfrastruktur::where('status', 'Proses')->count();
            $totalSelesai = LaporanInfrastruktur::where('status', 'Selesai')->count();
            $totalDitolak = LaporanInfrastruktur::where('status', 'Ditolak')->count();
            $laporanTerbaru = LaporanInfrastruktur::with('daerah')->latest()->take(5)->get();
        } else {
            $idDaerahPengguna = $penggunaAktif->id_daerah;
            $totalLaporan = LaporanInfrastruktur::where('id_daerah', $idDaerahPengguna)->count();
            $totalMenunggu = LaporanInfrastruktur::where('id_daerah', $idDaerahPengguna)->where('status', 'Menunggu')->count();
            $totalProses = LaporanInfrastruktur::where('id_daerah', $idDaerahPengguna)->where('status', 'Proses')->count();
            $totalSelesai = LaporanInfrastruktur::where('id_daerah', $idDaerahPengguna)->where('status', 'Selesai')->count();
            $totalDitolak = LaporanInfrastruktur::where('id_daerah', $idDaerahPengguna)->where('status', 'Ditolak')->count();
            $laporanTerbaru = LaporanInfrastruktur::with('daerah')->where('id_daerah', $idDaerahPengguna)->latest()->take(5)->get();
        }

        return view('admin.beranda', compact(
            'totalLaporan',
            'totalMenunggu',
            'totalProses',
            'totalSelesai',
            'totalDitolak',
            'laporanTerbaru',
            'chartTrendLabels',
            'chartTrendData',
            'danaDisetujui',
            'danaDitolak',
            'danaMenunggu',
            'chartRatingLabels',
            'chartRatingData'
        ));
    }

    public function tampilkanDaftarLaporan(\Illuminate\Http\Request $request)
    {
        $penggunaAktif = Auth::user();

        $query = LaporanInfrastruktur::with('daerah')->latest();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('tracking_id', 'like', "%{$search}%")
                    ->orWhereHas('daerah', function ($qDaerah) use ($search) {
                        $qDaerah->where('nama_daerah', 'like', "%{$search}%");
                    });
            });
        }

        if ($request->filled('status') && $request->input('status') !== 'Semua') {
            $query->where('status', $request->input('status'));
        }

        if ($penggunaAktif->role === 'Super Admin') {
            if ($request->filled('daerah') && $request->input('daerah') !== 'Semua') {
                $query->where('id_daerah', $request->input('daerah'));
            }
            $daftarLaporan = $query->paginate(15)->withQueryString();
            $daftarDaerah = \App\Models\Daerah::all();
        } else {
            $query->where('id_daerah', $penggunaAktif->id_daerah);
            $daftarLaporan = $query->paginate(15)->withQueryString();
            $daftarDaerah = collect();
        }

        return view('admin.laporan.indeks', compact('daftarLaporan', 'daftarDaerah'));
    }

    public function tampilkanDetailLaporan($id)
    {
        $penggunaAktif = Auth::user();

        if ($penggunaAktif->role === 'Super Admin') {
            $dataLaporan = LaporanInfrastruktur::with('daerah', 'analisisAi', 'pengajuanDana')->findOrFail($id);
        } else {
            $dataLaporan = LaporanInfrastruktur::with('daerah', 'analisisAi', 'pengajuanDana')
                ->where('id_daerah', $penggunaAktif->id_daerah)
                ->findOrFail($id);
        }

        return view('admin.laporan.detail', compact('dataLaporan'));
    }

    public function tampilkanPeta()
    {
        return view('admin.peta.indeks');
    }

    public function ambilDataTitikKejahatan()
    {
        $daftarTitikKejahatan = LaporanKejahatan::select('latitude', 'longitude')->get();
        return response()->json($daftarTitikKejahatan);
    }

    public function tampilkanDaftarPegawai()
    {
        if (Auth::user()->role !== 'Super Admin') {
            return abort(403, 'Akses khusus Super Admin.');
        }

        $daftarPegawai = User::where('role', 'Admin Daerah')->with('daerah')->latest()->paginate(15);

        return view('admin.pegawai.indeks', compact('daftarPegawai'));
    }

    public function perbaruiStatusPegawai(Request $request, $id)
    {
        if (Auth::user()->role !== 'Super Admin') {
            return abort(403, 'Akses khusus Super Admin.');
        }

        $request->validate([
            'status_akun' => ['required', 'in:aktif,nonaktif,ditolak'],
        ]);

        $pegawai = User::findOrFail($id);
        $pegawai->update(['status_akun' => $request->status_akun]);

        $pesan = $request->status_akun === 'aktif' ? 'Akun pegawai berhasil disetujui/diaktifkan.' : 'Akun pegawai telah ditolak/dinonaktifkan.';

        return back()->with('sukses', $pesan);
    }
}
