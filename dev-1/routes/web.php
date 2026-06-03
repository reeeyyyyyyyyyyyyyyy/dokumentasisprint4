<?php

use App\Http\Controllers\OtentikasiController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\PengajuanDanaController;

Route::get('/', [BerandaController::class, 'index'])->name('beranda');

Route::get('/lapor', [LaporanController::class, 'tampilkanFormLapor'])->name('lapor');
Route::post('/lapor', [LaporanController::class, 'prosesSimpanLaporan'])->name('proses.laporan');

Route::get('/lacak', [LaporanController::class, 'tampilkanFormLacak'])->name('lacak');
Route::post('/lacak', [LaporanController::class, 'prosesCariLaporan'])->name('proses.lacak');
Route::post('/lacak/{id}/ulasan', [LaporanController::class, 'simpanUlasan'])->name('lacak.ulasan');

Route::post('/lapor-kejahatan', [LaporanController::class, 'simpanKejahatan'])->name('lapor.kejahatan');

// =========================================================
// SPRINT 4 - FEATURE 6: Leaderboard & Poin Daerah [Dev 6]
// =========================================================
Route::get('/leaderboard', [\App\Http\Controllers\LeaderboardController::class, 'indeksPublik'])->name('leaderboard.indeks');
// =========================================================

// =========================================================
// SPRINT 4 - FEATURE 3: Asisten Virtual AI [Dev 3]
// =========================================================
Route::post('/chatbot/kirim', [\App\Http\Controllers\MinGapChatbotController::class, 'kirimPesan'])->name('chatbot.kirim');
Route::post('/chatbot/reset', [\App\Http\Controllers\MinGapChatbotController::class, 'bersihkanRiwayat'])->name('chatbot.reset');
Route::get('/chatbot/riwayat', [\App\Http\Controllers\MinGapChatbotController::class, 'ambilRiwayat'])->name('chatbot.riwayat');
// =========================================================

Route::prefix('portal-internal')->middleware('guest')->group(function () {
    Route::get('/', [OtentikasiController::class, 'tampilkanSambutan'])->name('sambutan');
    Route::get('/login', [OtentikasiController::class, 'tampilkanMasuk'])->name('masuk');
    Route::post('/login', [OtentikasiController::class, 'prosesMasuk'])->name('proses.masuk');
    Route::get('/daftar', [OtentikasiController::class, 'tampilkanDaftar'])->name('daftar');
    Route::post('/daftar', [OtentikasiController::class, 'prosesDaftar'])->name('proses.daftar');
});

Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'tampilkanBeranda'])->name('beranda');
    Route::get('/laporan', [AdminController::class, 'tampilkanDaftarLaporan'])->name('laporan.indeks');
    Route::get('/laporan/{id}', [AdminController::class, 'tampilkanDetailLaporan'])->name('laporan.detail');
    // =========================================================
    // SPRINT 4 - FEATURE 5: Audit Fisik & Timeline [Dev 5]
    // =========================================================
    Route::patch('/laporan/{id}', [\App\Http\Controllers\AuditFisikController::class, 'perbaruiStatusLaporan'])->name('laporan.perbarui');
    // =========================================================
    // =========================================================
    // SPRINT 4 - FEATURE 1: Verifikasi Dana Khusus [Dev 1]
    // =========================================================
    Route::get('/keuangan', [\App\Http\Controllers\AuditDanaController::class, 'tampilkanDaftarAudit'])->name('keuangan.indeks');
    Route::post('/pengajuan/{id}/proses-audit', [\App\Http\Controllers\AuditDanaController::class, 'prosesPersetujuanAudit'])->name('pengajuan.proses-audit');
    // =========================================================
    // =========================================================
    // SPRINT 4 - FEATURE 2: Ekspor Laporan [Dev 2]
    // =========================================================
    Route::get('/ekspor', [\App\Http\Controllers\LaporanEksporController::class, 'indeks'])->name('ekspor.indeks');
    Route::get('/ekspor/csv', [\App\Http\Controllers\LaporanEksporController::class, 'eksporCsv'])->name('ekspor.csv');
    Route::get('/ekspor/pdf', [\App\Http\Controllers\LaporanEksporController::class, 'eksporPdf'])->name('ekspor.pdf');
    // =========================================================
    Route::post('/pengajuan', [PengajuanDanaController::class, 'simpanPengajuan'])->name('pengajuan.simpan');
    Route::post('/pengajuan/{id}/proses', [PengajuanDanaController::class, 'prosesPersetujuan'])->name('pengajuan.proses');
    Route::post('/pengajuan/{id}/ajukan-ulang', [PengajuanDanaController::class, 'ajukanUlang'])->name('pengajuan.ajukan-ulang');
    Route::get('/peta', [AdminController::class, 'tampilkanPeta'])->name('peta.indeks');
    Route::get('/api/titik-kejahatan', [AdminController::class, 'ambilDataTitikKejahatan'])->name('api.titik-kejahatan');
    Route::get('/pegawai', [AdminController::class, 'tampilkanDaftarPegawai'])->name('pegawai.indeks');
    Route::patch('/pegawai/{id}', [AdminController::class, 'perbaruiStatusPegawai'])->name('pegawai.perbarui');

    Route::get('/chat/contacts', [\App\Http\Controllers\ChatController::class, 'getContacts']);
    Route::get('/chat/search', [\App\Http\Controllers\ChatController::class, 'searchUsers']);
    Route::get('/chat/messages/{userId}', [\App\Http\Controllers\ChatController::class, 'getMessages']);
    Route::post('/chat/messages/{userId}', [\App\Http\Controllers\ChatController::class, 'sendMessage']);
    Route::patch('/chat/messages/{userId}/read', [\App\Http\Controllers\ChatController::class, 'markAsRead']);

    Route::patch('/notifications/read-all', [\App\Http\Controllers\NotificationController::class, 'markAllAsRead']);
    Route::patch('/notifications/{id}/read', [\App\Http\Controllers\NotificationController::class, 'markAsRead']);

    // =========================================================
    // SPRINT 4 - FEATURE 4: Asisten AI Keputusan Admin [Dev 4]
    // =========================================================
    Route::get('/asisten-ai', [\App\Http\Controllers\AdminChatbotController::class, 'indeks'])->name('asisten-ai.indeks');
    Route::post('/asisten-ai/kirim', [\App\Http\Controllers\AdminChatbotController::class, 'kirimPesan'])->name('asisten-ai.kirim');
    Route::post('/asisten-ai/reset', [\App\Http\Controllers\AdminChatbotController::class, 'bersihkanRiwayat'])->name('asisten-ai.reset');
    Route::get('/asisten-ai/riwayat', [\App\Http\Controllers\AdminChatbotController::class, 'ambilRiwayat'])->name('asisten-ai.riwayat');
    // =========================================================
    Route::post('/keluar', [OtentikasiController::class, 'keluar'])->name('keluar');

    // =========================================================
    // SPRINT 4 - FEATURE 6: Leaderboard & Poin Daerah [Dev 6]
    // =========================================================
    Route::get('/leaderboard', [\App\Http\Controllers\LeaderboardController::class, 'indeksAdmin'])->name('leaderboard.indeks');
    Route::post('/leaderboard/bonus', [\App\Http\Controllers\LeaderboardController::class, 'tambahPoinBonus'])->name('leaderboard.bonus');
    // =========================================================
});

Route::post('/keluar', [OtentikasiController::class, 'keluar'])->name('keluar')->middleware('auth');