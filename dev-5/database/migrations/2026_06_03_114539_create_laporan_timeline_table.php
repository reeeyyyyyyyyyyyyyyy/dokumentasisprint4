<?php

// =========================================================
// SPRINT 4 - FEATURE 5: Audit Fisik & Timeline [Dev 5]
// =========================================================

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('laporan_timeline', function (Blueprint $table) {
            $table->id();
            $table->foreignId('laporan_infrastruktur_id')->constrained('laporan_infrastruktur')->onDelete('cascade');
            $table->string('status');
            $table->text('deskripsi');
            $table->timestamps();
        });

        // Seeding data historis untuk laporan yang sudah ada
        $laporans = \DB::table('laporan_infrastruktur')->get();
        foreach ($laporans as $laporan) {
            // 1. Semua laporan pasti memiliki tahapan awal "Menunggu"
            \DB::table('laporan_timeline')->insert([
                'laporan_infrastruktur_id' => $laporan->id,
                'status' => 'Menunggu',
                'deskripsi' => 'Laporan berhasil dibuat oleh warga dengan nomor tracking ID: ' . $laporan->tracking_id . ' dan sedang menunggu verifikasi oleh Admin.',
                'created_at' => $laporan->created_at,
                'updated_at' => $laporan->created_at,
            ]);

            // 2. Jika status saat ini adalah "Proses" atau "Selesai"
            if (in_array($laporan->status, ['Proses', 'Selesai'])) {
                $waktuProses = \Carbon\Carbon::parse($laporan->created_at)->addMinutes(15);
                \DB::table('laporan_timeline')->insert([
                    'laporan_infrastruktur_id' => $laporan->id,
                    'status' => 'Proses',
                    'deskripsi' => 'Status laporan diperbarui menjadi Proses. Pengerjaan perbaikan sedang dijadwalkan oleh dinas terkait.',
                    'created_at' => $waktuProses,
                    'updated_at' => $waktuProses,
                ]);
            }

            // 3. Jika status saat ini adalah "Selesai"
            if ($laporan->status === 'Selesai') {
                \DB::table('laporan_timeline')->insert([
                    'laporan_infrastruktur_id' => $laporan->id,
                    'status' => 'Selesai',
                    'deskripsi' => 'Perbaikan laporan telah selesai dikerjakan. Foto bukti pengerjaan telah diunggah dan divalidasi oleh petugas lapangan.',
                    'created_at' => $laporan->updated_at,
                    'updated_at' => $laporan->updated_at,
                ]);
            }

            // 4. Jika status saat ini adalah "Ditolak"
            if ($laporan->status === 'Ditolak') {
                \DB::table('laporan_timeline')->insert([
                    'laporan_infrastruktur_id' => $laporan->id,
                    'status' => 'Ditolak',
                    'deskripsi' => 'Laporan telah ditolak oleh Admin setelah dilakukan verifikasi berkas/lokasi.',
                    'created_at' => $laporan->updated_at,
                    'updated_at' => $laporan->updated_at,
                ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_timeline');
    }
};

// =========================================================
