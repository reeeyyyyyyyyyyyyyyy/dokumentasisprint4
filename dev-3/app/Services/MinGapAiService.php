<?php

// =========================================================
// SPRINT 4 - FEATURE 3: Asisten Virtual AI [Dev 3]
// =========================================================

namespace App\Services;

use App\Models\LaporanInfrastruktur;
use App\Models\LaporanKejahatan;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class MinGapAiService
{
    public function tanyaAi(string $pesan, array $riwayat = [])
    {
        $apiKey = env('OPENAI_API_KEY');

        if (!$apiKey) {
            return 'Waduh, mohon maaf ya Warga Bandung, saat ini kunci akses AI MinGAP belum dikonfigurasi. Silakan hubungi admin!';
        }

        $konteksDatabase = $this->deteksiDanCariTrackingId($pesan);

        $systemPrompt = "Nama kamu adalah MinGAP (Admin SIGAP), asisten AI yang ramah, hangat, komunikatif, dan sangat informatif milik Pemerintah Kota Bandung.\n\n"
            . "Tugas utama kamu:\n"
            . "1. Membantu dan membimbing warga Kota Bandung dalam melaporkan kejadian/isu pelayanan publik seperti jalan berlubang, lampu penerangan jalan umum (PJU) mati, pohon tumbang, genangan air/banjir, fasilitas sosial rusak, tindak kejahatan, dll.\n"
            . "2. Jika mendeteksi keadaan darurat (kejahatan aktif, kebakaran hebat, kecelakaan parah, korban terluka, bencana alam langsung), wajib mengingatkan warga dengan tegas namun tetap santun untuk segera menghubungi nomor darurat gratis Bandung Siaga 112.\n"
            . "3. Menjawab pertanyaan seputar cara melaporkan masalah lewat web SIGAP BDG secara ringkas (Unggah Foto -> Deteksi Lokasi -> Kirim & Dapatkan Tracking ID -> Lacak Progres).\n"
            . "4. Menjelaskan status laporan warga berdasarkan data resmi database yang disematkan di bawah.\n\n"
            . "Aturan komunikasi:\n"
            . "- Gunakan bahasa Indonesia yang santun, ramah, dan bersahabat. Sapa dengan sebutan hangat seperti 'Halo Warga Bandung!' atau 'Ada yang bisa MinGAP bantu hari ini?' dan berikan dukungan moral yang baik.\n"
            . "- Jawab secara lugas dan tidak bertele-tele.\n\n";

        if ($konteksDatabase) {
            $systemPrompt .= "Konteks Laporan Terkini dari Database:\n" . $konteksDatabase . "\n\n"
                . "Instruksi khusus: Sampaikan data laporan di atas dengan bahasa kamu yang bersahabat. Berikan pesan menenangkan bahwa laporan sedang/akan ditangani.";
        }

        $messages = [
            ['role' => 'system', 'content' => $systemPrompt]
        ];

        foreach ($riwayat as $chat) {
            $messages[] = [
                'role' => $chat['role'] === 'user' ? 'user' : 'assistant',
                'content' => $chat['content']
            ];
        }

        $messages[] = ['role' => 'user', 'content' => $pesan];

        try {
            $respons = Http::withToken($apiKey)
                ->timeout(15)
                ->post('https://api.openai.com/v1/chat/completions', [
                    'model' => 'gpt-4o-mini',
                    'messages' => $messages,
                    'temperature' => 0.7,
                ]);

            if ($respons->successful()) {
                $hasil = $respons->json();
                return $hasil['choices'][0]['message']['content'] ?? 'Waduh, MinGAP bingung meresponsnya. Bisa diulangi pertanyaannya?';
            }

            return 'Waduh, mohon maaf ya Warga Bandung, saat ini sistem koneksi MinGAP sedang mengalami gangguan teknis. Silakan coba lagi beberapa saat lagi!';
        } catch (\Exception $e) {
            return 'Waduh, sepertinya jaringan MinGAP sedang terganggu. Mari coba bicara beberapa saat lagi ya, Warga Bandung!';
        }
    }

    private function deteksiDanCariTrackingId(string $pesan)
    {
        if (preg_match('/(SIGAP-[A-Z0-9]{6})/i', $pesan, $cocokInf)) {
            $trackingId = Str::upper($cocokInf[1]);
            $laporan = LaporanInfrastruktur::with('daerah')->where('tracking_id', $trackingId)->first();

            if ($laporan) {
                $estimasi = $laporan->analisisAi->estimasi_biaya ?? null;
                $formattedEstimasi = $estimasi ? 'Rp ' . number_format($estimasi, 0, ',', '.') : 'Belum Dianalisis AI';
                return "Tipe: Laporan Kerusakan Infrastruktur\n"
                    . "Tracking ID: {$laporan->tracking_id}\n"
                    . "Kecamatan: " . ($laporan->daerah->nama_daerah ?? 'Tidak Diketahui') . "\n"
                    . "Status: {$laporan->status}\n"
                    . "Waktu Lapor: " . $laporan->created_at->format('d-m-Y H:i') . " WIB\n"
                    . "Estimasi Biaya Perbaikan: {$formattedEstimasi}";
            }

            return "Warga mencari Tracking ID '{$trackingId}', tetapi ID tersebut tidak ditemukan di database SIGAP BDG.";
        }

        if (preg_match('/(SOS-KJH-[0-9]+)/i', $pesan, $cocokKej)) {
            $trackingId = Str::upper($cocokKej[1]);
            $parts = explode('-', $trackingId);
            $id = intval(end($parts));
            $laporan = LaporanKejahatan::with('daerah')->find($id);

            if ($laporan) {
                return "Tipe: Laporan Kerawanan Kejahatan / SOS\n"
                    . "Tracking ID: {$trackingId}\n"
                    . "Kecamatan: " . ($laporan->daerah->nama_daerah ?? 'Tidak Diketahui') . "\n"
                    . "Status: Aktif\n"
                    . "Waktu Lapor: " . $laporan->created_at->format('d-m-Y H:i') . " WIB";
            }

            return "Warga mencari Tracking ID Kejahatan '{$trackingId}', tetapi ID tersebut tidak ditemukan di database SIGAP BDG.";
        }

        return null;
    }
}

// =========================================================
