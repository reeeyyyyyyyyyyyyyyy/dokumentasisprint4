# Panduan Implementasi JIRA & Git Commit - Developer 5
**Fitur: Modul Audit Fisik Timeline & Slider Before-After Laporan**

Panduan ini disusun untuk memudahkan Anda melakukan pemindahan kode (copy-paste) ke perangkat lokal Anda, serta melakukan Git Commit secara bertahap agar riwayat kontribusi Anda di GitHub terlihat produktif dan rapi sesuai pembagian kartu JIRA.

---

## 📅 Target Daily Report (JIRA)
> [!IMPORTANT]
> - Lakukan **Daily Report** di grup koordinasi Anda setiap kali Anda menyelesaikan **minimal 2 kali commit**.
> - Contoh laporan harian: *"Hari ini telah menyelesaikan JIRA task (SIGAP-68) dan (SIGAP-69) untuk modul Audit Fisik & Timeline."*

---

## 🛠️ Tahapan Git Commit (9 Commits)

Silakan lakukan copy-paste kode dan lakukan commit satu per satu dengan mengikuti instruksi di bawah ini:

### 1. Commit Pertama: Database Migration (Timeline Table)
*   **JIRA Task ID**: `SIGAP-69`
*   **File yang Dibuat**: `database/migrations/2026_06_03_114539_create_laporan_timeline_table.php`
*   **Perintah Commit**:
    ```bash
    git add database/migrations/*_create_laporan_timeline_table.php
    git commit -m "SIGAP-69"
    ```

### 3. Commit Ketiga: Membuat Model LaporanTimeline & Hubungkan Relasi
*   **JIRA Task ID**: `SIGAP-70`
*   **File yang Dibuat/Diubah**: 
    - `app/Models/LaporanTimeline.php`
    - `app/Models/LaporanInfrastruktur.php`
*   **Perintah Commit**:
    ```bash
    git add app/Models/LaporanTimeline.php app/Models/LaporanInfrastruktur.php
    git commit -m "SIGAP-70"
    ```

### 4. Commit Keempat: Membuat AuditFisikController
*   **JIRA Task ID**: `SIGAP-71`
*   **File yang Dibuat/Diubah**: 
    - `app/Http/Controllers/AuditFisikController.php`
    - `app/Http/Controllers/AdminController.php` (hapus metode perbaruiStatusLaporan lama)
*   **Perintah Commit**:
    ```bash
    git add app/Http/Controllers/AuditFisikController.php app/Http/Controllers/AdminController.php
    git commit -m "SIGAP-71"
    ```

### 5. Commit Kelima: Integrasi Pembuatan Timeline pada Laporan Baru
*   **JIRA Task ID**: `SIGAP-72`
*   **File yang Diubah**: `app/Http/Controllers/LaporanController.php`
*   **Perintah Commit**:
    ```bash
    git add app/Http/Controllers/LaporanController.php
    git commit -m "SIGAP-72"
    ```

### 6. Commit Keenam: Registrasi Rute Web Baru (Routes)
*   **JIRA Task ID**: `SIGAP-73`
*   **File yang Diubah**: `routes/web.php`
*   **Perintah Commit**:
    ```bash
    git add routes/web.php
    git commit -m "SIGAP-73"
    ```

### 7. Commit Ketujuh: Modifikasi View Admin Detail (Form Perbarui Status)
*   **JIRA Task ID**: `SIGAP-74`
*   **File yang Diubah**: `resources/views/admin/laporan/detail.blade.php`
*   **Perintah Commit**:
    ```bash
    git add resources/views/admin/laporan/detail.blade.php
    git commit -m "SIGAP-74"
    ```

### 8. Commit Kedelapan: Modifikasi View Warga Lacak (Timeline & Slider Before-After)
*   **JIRA Task ID**: `SIGAP-75`
*   **File yang Diubah**: `resources/views/laporan/lacak.blade.php`
*   **Perintah Commit**:
    ```bash
    git add resources/views/laporan/lacak.blade.php
    git commit -m "SIGAP-75"
    ```


## 🔍 Lokasi Kode & Penanda Komentar
Seluruh perubahan kode Anda telah dibungkus dengan komentar penanda berikut untuk memudahkan proses audit:
```php
// =========================================================
// SPRINT 4 - FEATURE 5: Audit Fisik & Timeline [Dev 5]
// =========================================================
... kode milik Anda ...
// =========================================================
```
Pastikan komentar ini tetap ada saat Anda melakukan push ke repositori GitHub utama kelompok. Selamat bekerja!
