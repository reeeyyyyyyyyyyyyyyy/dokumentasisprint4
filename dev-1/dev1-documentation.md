# Panduan Implementasi JIRA & Git Commit - Developer 1
**Fitur: Modul Verifikasi Dana Khusus (Nominal > Estimasi AI) & Ajukan Ulang**

Panduan ini disusun untuk memudahkan Anda melakukan pemindahan kode (copy-paste) ke perangkat lokal Anda, serta melakukan Git Commit secara bertahap agar riwayat kontribusi Anda di GitHub terlihat produktif dan rapi sesuai pembagian kartu JIRA.

---

## 📅 Target Daily Report (JIRA)
> [!IMPORTANT]
> - Lakukan **Daily Report** di grup koordinasi Anda setiap kali Anda menyelesaikan **minimal 2 kali commit**.
> - Contoh laporan harian: *"Hari ini telah menyelesaikan JIRA task (MIGRATE-1) dan (CONTROLLER-1) untuk modul Verifikasi Dana Khusus."*

---

## 🛠️ Tahapan Git Commit (6 Commits)

Silakan lakukan copy-paste kode dan lakukan commit satu per satu dengan mengikuti instruksi di bawah ini:

### 1. Commit Pertama: Database Migration
*   **JIRA Task ID**: `SIGAP-43`
*   **File yang Dibuat**: `database/migrations/xxxx_add_catatan_to_pengajuan_dana_table.php`
*   **Perintah Commit**:
    ```bash
    git add database/migrations/*_add_catatan_to_pengajuan_dana_table.php
    git commit -m "SIGAP-43"
    ```

### 2. Commit Kedua: Update Model PengajuanDana
*   **JIRA Task ID**: `SIGAP-44`
*   **File yang Diubah**: `app/Models/PengajuanDana.php`
*   **Perintah Commit**:
    ```bash
    git add app/Models/PengajuanDana.php
    git commit -m "SIGAP-44"
    ```

### 3. Commit Ketiga: Membuat AuditDanaController
*   **JIRA Task ID**: `SIGAP-45`
*   **File yang Dibuat**: `app/Http/Controllers/AuditDanaController.php`
*   **Perintah Commit**:
    ```bash
    git add app/Http/Controllers/AuditDanaController.php
    git commit -m "SIGAP-45"
    ```

### 4. Commit Keempat: Registrasi Rute Web (Routes)
*   **JIRA Task ID**: `SIGAP-46`
*   **File yang Diubah**: `routes/web.php`
*   **Perintah Commit**:
    ```bash
    git add routes/web.php
    git commit -m "SIGAP-46"
    ```

### 5. Commit Kelima: Dashboard Keuangan Super Admin (Blade View)
*   **JIRA Task ID**: `SIGAP-47`
*   **File yang Diubah**: `resources/views/admin/keuangan/indeks.blade.php`
*   **Perintah Commit**:
    ```bash
    git add resources/views/admin/keuangan/indeks.blade.php
    git commit -m "SIGAP-47"
    ```

### 6. Commit Keenam: Detail Laporan Admin Daerah (Blade View)
*   **JIRA Task ID**: `SIGAP-48`
*   **File yang Diubah**: `resources/views/admin/laporan/detail.blade.php`
*   **Perintah Commit**:
    ```bash
    git add resources/views/admin/laporan/detail.blade.php
    git commit -m "SIGAP-48"
    ```

---

## 🔍 Lokasi Kode & Penanda Komentar
Seluruh perubahan kode Anda telah dibungkus dengan komentar penanda berikut untuk memudahkan proses audit:
```php
// =========================================================
// SPRINT 4 - FEATURE 1: Verifikasi Dana Khusus [Dev 1]
// =========================================================
... kode milik Anda ...
// =========================================================
```
Pastikan komentar ini tetap ada saat Anda melakukan push ke repositori GitHub utama kelompok. Selamat bekerja!
