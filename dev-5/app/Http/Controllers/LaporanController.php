<?php

namespace App\Http\Controllers;

use App\Models\Daerah;
use App\Models\LaporanInfrastruktur;
use App\Models\LaporanKejahatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class LaporanController extends Controller
{
    public function tampilkanFormLapor()
    {
        return view('laporan.buat');
    }

    public function prosesSimpanLaporan(Request $request)
    {
        $request->validate([
            'foto'      => ['required', 'file', 'image', 'max:5120'],
            'latitude'  => ['required', 'numeric'],
            'longitude' => ['required', 'numeric'],
        ]);

        $nilaiHash       = md5_file($request->file('foto')->path());
        $laporanDuplikat = LaporanInfrastruktur::where('hash_foto', $nilaiHash)->first();

        if ($laporanDuplikat) {
            return back()->withErrors(['foto' => 'Laporan ditolak: Foto ini sudah pernah digunakan untuk melapor sebelumnya!'])->withInput();
        }

        $fotoAwal         = $request->file('foto')->store('laporan', 'public');
        $trackingId       = 'SIGAP-' . Str::upper(Str::random(6));
        $idDaerahTerpilih = 1;

        try {
            $nilaiLatitude  = $request->input('latitude');
            $nilaiLongitude = $request->input('longitude');

            $responsApi = Http::withHeaders(['User-Agent' => 'SigapBdgApp/1.0 (student project)'])
                ->get("https://nominatim.openstreetmap.org/reverse?format=json&lat={$nilaiLatitude}&lon={$nilaiLongitude}");

            $dataPeta   = $responsApi->json();
            $alamatPeta = $dataPeta['address'] ?? [];

            $namaKecamatanApi = $alamatPeta['subdistrict']
                ?? $alamatPeta['town']
                ?? $alamatPeta['city_district']
                ?? $alamatPeta['suburb']
                ?? $alamatPeta['village']
                ?? null;

            if ($namaKecamatanApi) {
                $namaKecamatanApi = str_replace('Kecamatan ', '', $namaKecamatanApi);
                $namaKecamatanApi = str_replace('Kelurahan ', '', $namaKecamatanApi);
                $namaKecamatanApi = str_replace(' ', '', $namaKecamatanApi);

                $kecamatanDitemukan = Daerah::whereRaw("REPLACE(nama_daerah, ' ', '') LIKE ?", ['%' . $namaKecamatanApi . '%'])->first();

                if ($kecamatanDitemukan) {
                    $idDaerahTerpilih = $kecamatanDitemukan->id;
                }
            }
        } catch (\Exception $e) {
            $idDaerahTerpilih = 1;
        }

        $laporanBaru = LaporanInfrastruktur::create([
            'id_daerah'   => $idDaerahTerpilih,
            'tracking_id' => $trackingId,
            'latitude'    => $request->input('latitude'),
            'longitude'   => $request->input('longitude'),
            'foto_awal'   => $fotoAwal,
            'hash_foto'   => $nilaiHash,
            'status'      => 'Menunggu',
        ]);

        // =========================================================
        // SPRINT 4 - FEATURE 5: Audit Fisik & Timeline [Dev 5]
        // =========================================================
        \App\Models\LaporanTimeline::create([
            'laporan_infrastruktur_id' => $laporanBaru->id,
            'status' => 'Menunggu',
            'deskripsi' => 'Laporan berhasil dibuat oleh warga dengan nomor tracking ID: ' . $trackingId . ' dan sedang menunggu verifikasi oleh Admin.',
        ]);
        // =========================================================

        // =========================================================
        // SPRINT 4 - FEATURE 6: Leaderboard & Poin Daerah [Dev 6]
        // =========================================================
        \App\Models\PoinKontribusiDaerah::create([
            'id_daerah' => $laporanBaru->id_daerah,
            'laporan_infrastruktur_id' => $laporanBaru->id,
            'poin' => 10,
            'kategori' => 'Laporan Baru',
            'deskripsi' => 'Apresiasi partisipasi warga melaporkan infrastruktur rusak dengan ID: ' . $trackingId,
        ]);
        // =========================================================

        \App\Services\LayananSimulasiAi::prosesAnalisis($laporanBaru->id, $fotoAwal);

        $admins = \App\Models\User::where('role', 'Super Admin')
            ->orWhere(function($query) use ($idDaerahTerpilih) {
                $query->where('role', 'Admin Daerah')->where('id_daerah', $idDaerahTerpilih);
            })->get();
            
        \Illuminate\Support\Facades\Notification::send($admins, new \App\Notifications\LaporanMasukNotification($laporanBaru));

        event(new \App\Events\LaporanMasukEvent($laporanBaru));

        return back()->with('trackingBerhasil', $trackingId);
    }

    public function simpanKejahatan(Request $request)
    {
        $request->validate([
            'latitude'  => ['required', 'numeric'],
            'longitude' => ['required', 'numeric'],
        ]);

        LaporanKejahatan::create([
            'id_daerah' => 1,
            'latitude'  => $request->input('latitude'),
            'longitude' => $request->input('longitude'),
        ]);

        return response()->json(['sukses' => true]);
    }

    public function tampilkanFormLacak(Request $request)
    {
        $kodeLacak = session('sukses_ulasan_tracking_id');
        $dataLaporan = null;
        
        if ($kodeLacak) {
            $dataLaporan = LaporanInfrastruktur::where('tracking_id', $kodeLacak)->first();
        }
        
        return view('laporan.lacak', compact('dataLaporan', 'kodeLacak'));
    }

    public function prosesCariLaporan(Request $request)
    {
        $request->validate([
            'tracking_id' => ['required', 'string'],
        ]);

        $kodeLacak   = Str::upper(trim($request->input('tracking_id')));
        $dataLaporan = LaporanInfrastruktur::where('tracking_id', $kodeLacak)->first();

        return view('laporan.lacak', compact('dataLaporan', 'kodeLacak'));
    }

    public function simpanUlasan(Request $request, $id)
    {
        $request->validate([
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'ulasan' => ['nullable', 'string', 'max:500'],
        ]);

        $dataLaporan = LaporanInfrastruktur::findOrFail($id);

        if ($dataLaporan->status !== 'Selesai') {
            return back()->with('error', 'Laporan belum selesai.');
        }

        $ratingInput = (int) $request->input('rating');
        $poinUlasan = $ratingInput * 10;

        \App\Models\UlasanLaporan::create([
            'laporan_infrastruktur_id' => $id,
            'rating'     => $ratingInput,
            'ulasan'     => $request->input('ulasan'),
        ]);

        // =========================================================
        // SPRINT 4 - FEATURE 6: Leaderboard & Poin Daerah [Dev 6]
        // =========================================================
        \App\Models\PoinKontribusiDaerah::create([
            'id_daerah' => $dataLaporan->id_daerah,
            'laporan_infrastruktur_id' => $dataLaporan->id,
            'poin' => $poinUlasan,
            'kategori' => 'Ulasan Warga',
            'deskripsi' => 'Apresiasi ulasan warga dengan rating ' . $ratingInput . ' bintang.',
        ]);
        // =========================================================

        return redirect()->route('lacak')
            ->with('sukses_ulasan_tracking_id', $dataLaporan->tracking_id)
            ->with('sukses_ulasan', 'Terima kasih! Ulasan Anda berhasil dikirim.');
    }
}
