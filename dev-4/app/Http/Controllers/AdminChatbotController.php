<?php

// =========================================================
// SPRINT 4 - FEATURE 4: Asisten AI Keputusan Admin [Dev 4]
// =========================================================

namespace App\Http\Controllers;

use App\Models\LaporanInfrastruktur;
use App\Services\AdminDecisionService;
use Illuminate\Http\Request;

class AdminChatbotController extends Controller
{
    protected $aiService;

    public function __construct(AdminDecisionService $aiService)
    {
        $this->aiService = $aiService;
    }

    public function indeks(Request $request)
    {
        // Pemicu Analisis Laporan Cepat dari halaman detail laporan
        if ($request->has('laporan_id')) {
            $laporanId = $request->input('laporan_id');
            $laporan = LaporanInfrastruktur::with(['daerah', 'analisisAi', 'pengajuanDana' => function ($q) {
                $q->latest();
            }])->find($laporanId);

            if ($laporan) {
                $trackingId = $laporan->tracking_id;
                $kecamatan = $laporan->daerah->nama_daerah ?? 'Tidak Diketahui';
                $statusLaporan = $laporan->status;
                $jenisKerusakan = $laporan->analisisAi->jenis_kerusakan ?? 'Belum Dianalisis AI';
                $tingkatKeparahan = $laporan->analisisAi->tingkat_keparahan ?? 'Belum Dianalisis AI';
                $estimasiBiaya = $laporan->analisisAi->estimasi_biaya ?? 0;

                $pengajuan = $laporan->pengajuanDana->first();
                $nominalDiajukan = $pengajuan ? $pengajuan->nominal_diajukan : null;
                $statusPengajuan = $pengajuan ? $pengajuan->status_approval : 'Belum Diajukan';

                $prompt = "Berikan analisis keputusan untuk laporan berikut:\n"
                    . "- Tracking ID: {$trackingId}\n"
                    . "- Kecamatan: {$kecamatan}\n"
                    . "- Status Laporan: {$statusLaporan}\n"
                    . "- Jenis Kerusakan (AI): {$jenisKerusakan}\n"
                    . "- Tingkat Keparahan (AI): {$tingkatKeparahan}\n"
                    . "- Estimasi Biaya (AI): Rp " . number_format($estimasiBiaya, 0, ',', '.') . "\n";

                if ($nominalDiajukan) {
                    $selisih = $nominalDiajukan - $estimasiBiaya;
                    $selisihPersen = $estimasiBiaya > 0 ? (($selisih / $estimasiBiaya) * 100) : 0;
                    
                    $prompt .= "- Status Pengajuan Dana: {$statusPengajuan}\n"
                        . "- Nominal Diajukan: Rp " . number_format($nominalDiajukan, 0, ',', '.') . "\n"
                        . "- Selisih Anggaran: Rp " . number_format($selisih, 0, ',', '.') . " (" . number_format($selisihPersen, 1, ',', '.') . "%)\n";
                } else {
                    $prompt .= "- Status Pengajuan Dana: Belum Diajukan\n";
                }

                $prompt .= "\nBerikan ringkasan laporan, analisis kewajaran anggaran yang diajukan, rekomendasi prioritas perbaikan, serta saran keputusan yang harus diambil admin (Setujui/Tolak/Minta Penyesuaian) beserta pertimbangan rasionalnya.";

                // Hapus riwayat chat lama dan buat baru khusus untuk analisis laporan ini
                session()->forget('admin_chat_history');
                
                $jawaban = $this->aiService->tanyaAi($prompt, []);

                $riwayat = [
                    ['role' => 'user', 'content' => "Mohon berikan analisis keputusan untuk laporan dengan Tracking ID: {$trackingId}"],
                    ['role' => 'assistant', 'content' => $jawaban]
                ];

                session()->put('admin_chat_history', $riwayat);

                return redirect()->route('admin.asisten-ai.indeks');
            }
        }

        return view('admin.asisten-ai.index');
    }

    public function ambilRiwayat()
    {
        $riwayat = session()->get('admin_chat_history', []);
        return response()->json(['riwayat' => $riwayat]);
    }

    public function kirimPesan(Request $request)
    {
        $request->validate([
            'pesan' => ['required', 'string', 'max:1500']
        ]);

        $pesan = trim($request->input('pesan'));
        $riwayat = session()->get('admin_chat_history', []);

        $jawaban = $this->aiService->tanyaAi($pesan, $riwayat);

        $riwayat[] = ['role' => 'user', 'content' => $pesan];
        $riwayat[] = ['role' => 'assistant', 'content' => $jawaban];

        // Batasi riwayat percakapan admin maksimal 20 pesan
        if (count($riwayat) > 20) {
            $riwayat = array_slice($riwayat, -20);
        }

        session()->put('admin_chat_history', $riwayat);

        return response()->json([
            'jawaban' => $jawaban,
            'riwayat' => $riwayat
        ]);
    }

    public function bersihkanRiwayat()
    {
        session()->forget('admin_chat_history');
        return response()->json(['sukses' => true]);
    }
}

// =========================================================
