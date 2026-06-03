<?php

// =========================================================
// SPRINT 4 - FEATURE 6: Leaderboard & Poin Daerah [Dev 6]
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
        Schema::create('poin_kontribusi_daerah', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_daerah')->constrained('daerah')->onDelete('cascade');
            $table->foreignId('laporan_infrastruktur_id')->nullable()->constrained('laporan_infrastruktur')->onDelete('cascade');
            $table->integer('poin');
            $table->string('kategori');
            $table->string('deskripsi');
            $table->timestamps();
        });

        // Seeding data poin historis secara otomatis
        $laporans = \DB::table('laporan_infrastruktur')->get();
        foreach ($laporans as $laporan) {
            // 1. Setiap laporan masuk mendapatkan +10 poin kontribusi daerah (Partisipasi Warga)
            \DB::table('poin_kontribusi_daerah')->insert([
                'id_daerah' => $laporan->id_daerah,
                'laporan_infrastruktur_id' => $laporan->id,
                'poin' => 10,
                'kategori' => 'Laporan Baru',
                'deskripsi' => 'Apresiasi partisipasi warga melaporkan infrastruktur rusak dengan ID: ' . $laporan->tracking_id,
                'created_at' => $laporan->created_at,
                'updated_at' => $laporan->created_at,
            ]);

            // 2. Laporan dengan status "Proses" atau "Selesai" mendapat tambahan +20 poin (Respon Cepat)
            if (in_array($laporan->status, ['Proses', 'Selesai'])) {
                $waktuProses = \Carbon\Carbon::parse($laporan->created_at)->addMinutes(15);
                \DB::table('poin_kontribusi_daerah')->insert([
                    'id_daerah' => $laporan->id_daerah,
                    'laporan_infrastruktur_id' => $laporan->id,
                    'poin' => 20,
                    'kategori' => 'Respon Cepat',
                    'deskripsi' => 'Respon cepat pembaruan status laporan menjadi Proses oleh Admin Daerah.',
                    'created_at' => $waktuProses,
                    'updated_at' => $waktuProses,
                ]);
            }

            // 3. Laporan dengan status "Selesai" mendapat tambahan +50 poin (Penyelesaian Fisik)
            if ($laporan->status === 'Selesai') {
                \DB::table('poin_kontribusi_daerah')->insert([
                    'id_daerah' => $laporan->id_daerah,
                    'laporan_infrastruktur_id' => $laporan->id,
                    'poin' => 50,
                    'kategori' => 'Penyelesaian',
                    'deskripsi' => 'Penyelesaian perbaikan infrastruktur secara fisik di lapangan.',
                    'created_at' => $laporan->updated_at,
                    'updated_at' => $laporan->updated_at,
                ]);
            }
        }

        // 4. Seeding data poin untuk setiap ulasan/rating warga yang sudah ada
        $ulasans = \DB::table('ulasan_laporan')->get();
        foreach ($ulasans as $ulasan) {
            $laporan = \DB::table('laporan_infrastruktur')->find($ulasan->laporan_infrastruktur_id);
            if ($laporan) {
                $poinUlasan = $ulasan->rating * 10;
                \DB::table('poin_kontribusi_daerah')->insert([
                    'id_daerah' => $laporan->id_daerah,
                    'laporan_infrastruktur_id' => $laporan->id,
                    'poin' => $poinUlasan,
                    'kategori' => 'Ulasan Warga',
                    'deskripsi' => 'Apresiasi ulasan warga dengan rating ' . $ulasan->rating . ' bintang.',
                    'created_at' => $ulasan->created_at,
                    'updated_at' => $ulasan->created_at,
                ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('poin_kontribusi_daerah');
    }
};

// =========================================================
