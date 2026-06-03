<?php

// =========================================================
// SPRINT 4 - FEATURE 5: Audit Fisik & Timeline [Dev 5]
// =========================================================

namespace App\Http\Controllers;

use App\Models\LaporanInfrastruktur;
use App\Models\LaporanTimeline;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuditFisikController extends Controller
{
    public function perbaruiStatusLaporan(Request $request, $id)
    {
        $request->validate([
            'status' => ['required', 'in:Menunggu,Proses,Selesai'],
            'foto_selesai' => ['nullable', 'required_if:status,Selesai', 'image', 'mimes:jpeg,png,jpg', 'max:5120'],
        ]);

        $penggunaAktif = Auth::user();

        if ($penggunaAktif->role === 'Super Admin') {
            $dataLaporan = LaporanInfrastruktur::findOrFail($id);
        } else {
            $dataLaporan = LaporanInfrastruktur::where('id_daerah', $penggunaAktif->id_daerah)->findOrFail($id);
        }

        $statusBaru = $request->input('status');
        $oldStatus = $dataLaporan->status;
        $dataUpdate = ['status' => $statusBaru];

        if ($statusBaru === 'Selesai' && $request->hasFile('foto_selesai')) {
            $pathFotoSelesai = $request->file('foto_selesai')->store('laporan/selesai', 'public');
            $dataUpdate['foto_selesai'] = $pathFotoSelesai;
        }

        $dataLaporan->update($dataUpdate);

        // Hanya catat timeline jika statusnya berubah
        if ($oldStatus !== $statusBaru) {
            $deskripsiTimeline = match ($statusBaru) {
                'Menunggu' => 'Status laporan dikembalikan menjadi Menunggu verifikasi ulang oleh petugas.',
                'Proses' => 'Status laporan diperbarui menjadi Proses. Pengerjaan perbaikan sedang dijadwalkan oleh dinas terkait.',
                'Selesai' => 'Perbaikan laporan telah selesai dikerjakan. Foto bukti pengerjaan telah diunggah dan divalidasi oleh petugas lapangan.',
                default => 'Status laporan diperbarui.'
            };

            LaporanTimeline::create([
                'laporan_infrastruktur_id' => $dataLaporan->id,
                'status' => $statusBaru,
                'deskripsi' => $deskripsiTimeline,
            ]);

            // =========================================================
            // SPRINT 4 - FEATURE 6: Leaderboard & Poin Daerah [Dev 6]
            // =========================================================
            if ($statusBaru === 'Proses') {
                \App\Models\PoinKontribusiDaerah::create([
                    'id_daerah' => $dataLaporan->id_daerah,
                    'laporan_infrastruktur_id' => $dataLaporan->id,
                    'poin' => 20,
                    'kategori' => 'Respon Cepat',
                    'deskripsi' => 'Respon cepat pembaruan status laporan menjadi Proses oleh Admin Daerah.',
                ]);
            } elseif ($statusBaru === 'Selesai') {
                \App\Models\PoinKontribusiDaerah::create([
                    'id_daerah' => $dataLaporan->id_daerah,
                    'laporan_infrastruktur_id' => $dataLaporan->id,
                    'poin' => 50,
                    'kategori' => 'Penyelesaian',
                    'deskripsi' => 'Penyelesaian perbaikan infrastruktur secara fisik di lapangan.',
                ]);
            }
            // =========================================================
        }

        return redirect()->route('admin.laporan.detail', $id)->with('sukses', 'Status laporan berhasil diperbarui menjadi "' . $statusBaru . '".');
    }
}

// =========================================================
