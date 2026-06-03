<?php

// =========================================================
// SPRINT 4 - FEATURE 6: Leaderboard & Poin Daerah [Dev 6]
// =========================================================

namespace App\Http\Controllers;

use App\Models\Daerah;
use App\Models\PoinKontribusiDaerah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LeaderboardController extends Controller
{
    public function indeksPublik()
    {
        $kecamatans = Daerah::with(['poinKontribusi', 'laporanInfrastruktur.ulasanLaporan'])->get();

        $leaderboard = $kecamatans->map(function ($kecamatan) {
            $totalPoin = $kecamatan->poinKontribusi->sum('poin');
            $totalLaporan = $kecamatan->laporanInfrastruktur->count();
            $totalSelesai = $kecamatan->laporanInfrastruktur->where('status', 'Selesai')->count();
            $rasioPenyelesaian = $totalLaporan > 0 ? round(($totalSelesai / $totalLaporan) * 100, 1) : 0;

            // Hitung rata-rata rating ulasan
            $ratings = [];
            foreach ($kecamatan->laporanInfrastruktur as $laporan) {
                foreach ($laporan->ulasanLaporan as $ulasan) {
                    $ratings[] = $ulasan->rating;
                }
            }
            $rataRating = count($ratings) > 0 ? round(array_sum($ratings) / count($ratings), 1) : 0;

            return (object) [
                'id' => $kecamatan->id,
                'nama_daerah' => $kecamatan->nama_daerah,
                'total_poin' => $totalPoin,
                'total_laporan' => $totalLaporan,
                'total_selesai' => $totalSelesai,
                'rasio_penyelesaian' => $rasioPenyelesaian,
                'rata_rating' => $rataRating,
            ];
        })->sortByDesc('total_poin')->values();

        // SPRINT 4 - FEATURE 6: Leaderboard & Poin Daerah [Dev 6]
        foreach ($leaderboard as $index => $item) {
            $item->rank = $index + 1;
        }

        return view('leaderboard.index', compact('leaderboard'));
    }

    public function indeksAdmin(Request $request)
    {
        $penggunaAktif = Auth::user();

        $daftarDaerah = Daerah::all();

        $riwayatPoin = PoinKontribusiDaerah::with(['daerah', 'laporanInfrastruktur'])
            ->latest()
            ->paginate(15);

        // Cari kecamatan dengan poin tertinggi untuk info card
        $kecamatans = Daerah::with(['poinKontribusi'])->get();
        $topKecamatan = $kecamatans->map(function ($kec) {
            return (object) [
                'nama' => $kec->nama_daerah,
                'poin' => $kec->poinKontribusi->sum('poin')
            ];
        })->sortByDesc('poin')->first();

        return view('admin.leaderboard.index', compact('daftarDaerah', 'riwayatPoin', 'topKecamatan'));
    }

    public function tambahPoinBonus(Request $request)
    {
        if (Auth::user()->role !== 'Super Admin') {
            abort(403, 'Akses khusus Super Admin.');
        }

        $request->validate([
            'id_daerah' => ['required', 'exists:daerah,id'],
            'poin' => ['required', 'integer', 'min:1', 'max:500'],
            'deskripsi' => ['required', 'string', 'max:500'],
        ]);

        PoinKontribusiDaerah::create([
            'id_daerah' => $request->input('id_daerah'),
            'poin' => $request->input('poin'),
            'kategori' => 'Bonus Spesial',
            'deskripsi' => $request->input('deskripsi'),
        ]);

        return back()->with('sukses', 'Bonus poin berhasil ditambahkan ke kecamatan!');
    }
}

// =========================================================
