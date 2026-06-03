<?php

// =========================================================
// SPRINT 4 - FEATURE 4: Asisten AI Keputusan Admin [Dev 4]
// =========================================================

namespace App\Services;

use Illuminate\Support\Facades\Http;

class AdminDecisionService
{
    public function tanyaAi(string $pesan, array $riwayat = [])
    {
        $apiKey = env('OPENAI_API_KEY');

        if (!$apiKey) {
            return 'Konfigurasi API Key OpenAI belum diatur di server. Hubungi Super Admin untuk menyelesaikan konfigurasi ini.';
        }

        $systemPrompt = "Nama kamu adalah Asisten Keputusan SIGAP (SIGAP Decision Assistant), kecerdasan buatan analitis yang bertindak sebagai penasihat internal khusus bagi Administrator dan Super Admin Kota Bandung.\n\n"
            . "Tugas utama kamu:\n"
            . "1. Membantu admin menganalisis detail laporan infrastruktur secara mendalam.\n"
            . "2. Mengevaluasi kewajaran nominal dana yang diajukan oleh Admin Daerah dibandingkan dengan estimasi biaya awal dari AI.\n"
            . "3. Memberikan rekomendasi keputusan (Setuju, Tolak, atau Negosiasi Anggaran) dan menentukan tingkat prioritas perbaikan (Tinggi, Sedang, Rendah) berdasarkan keparahan.\n\n"
            . "Kriteria penilaian kewajaran anggaran:\n"
            . "- Pengajuan <= Estimasi AI: Kategorikan sebagai 'Sangat Wajar' atau 'Wajar'. Rekomendasikan untuk langsung disetujui.\n"
            . "- Pengajuan melebihi Estimasi AI s.d 20%: Kategorikan sebagai 'Wajar dengan Penyesuaian'. Rekomendasikan persetujuan jika catatan alasan logis.\n"
            . "- Pengajuan melebihi Estimasi AI > 20%: Kategorikan sebagai 'Kurang Wajar'. Rekomendasikan penolakan atau negosiasi ulang anggaran kecuali ada justifikasi darurat/lapangan yang krusial.\n\n"
            . "Klasifikasi prioritas perbaikan:\n"
            . "- Prioritas Tinggi: Kerusakan Berat pada fasilitas publik vital (jalan utama berlubang besar/amblas, jembatan retak parah, banjir bandang).\n"
            . "- Prioritas Sedang: Kerusakan Sedang yang mengganggu kenyamanan warga (lubang jalan biasa, trotoar amblas sebagian).\n"
            . "- Prioritas Rendah: Kerusakan Ringan/Estetika (retak rambut aspal, cat jembatan terkelupas, papan informasi rusak).\n\n"
            . "Aturan komunikasi:\n"
            . "- Gunakan bahasa Indonesia yang formal, taktis, profesional, lugas, dan objektif.\n"
            . "- Hindari penggunaan emotikon, emoji, atau bahasa informal.\n"
            . "- Fokus pada rekomendasi tindakan nyata dan analisis angka anggaran.";

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
                ->timeout(20)
                ->post('https://api.openai.com/v1/chat/completions', [
                    'model' => 'gpt-4o-mini',
                    'messages' => $messages,
                    'temperature' => 0.4,
                ]);

            if ($respons->successful()) {
                $hasil = $respons->json();
                return $hasil['choices'][0]['message']['content'] ?? 'Gagal memproses respons dari server AI.';
            }

            return 'Asisten AI sedang mengalami gangguan saat menghubungi server kecerdasan buatan. Silakan coba kembali nanti.';
        } catch (\Exception $e) {
            return 'Koneksi jaringan menuju server asisten AI terputus. Pastikan konfigurasi jaringan server Anda berjalan lancar.';
        }
    }
}

// =========================================================
