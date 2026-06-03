# Panduan Implementasi JIRA & Git Commit - Developer 6
**Fitur: Modul Poin Kontribusi & Papan Peringkat Kecamatan (Kecamatan Ter-SIGAP)**

Panduan ini disusun untuk memudahkan Anda melakukan pemindahan kode (copy-paste) ke perangkat lokal Anda, serta melakukan Git Commit secara bertahap agar riwayat kontribusi Anda di GitHub terlihat produktif dan rapi sesuai pembagian kartu JIRA.

---

## 📅 Target Daily Report (JIRA)
> [!IMPORTANT]
> - Lakukan **Daily Report** di grup koordinasi Anda setiap kali Anda menyelesaikan **minimal 2 kali commit**.
> - Contoh laporan harian: *"Hari ini telah menyelesaikan JIRA task (SIGAP-77) dan (SIGAP-78) untuk modul Poin Kontribusi & Leaderboard."*

---

## 🛠️ Tahapan Git Commit (10 Commits)

Silakan lakukan copy-paste kode dan lakukan commit satu per satu dengan mengikuti instruksi di bawah ini:

### 1. Commit Pertama: Database Migration (Poin Table)
*   **JIRA Task ID**: `SIGAP-77`
*   **File yang Dibuat**: `database/migrations/2026_06_03_122130_create_poin_kontribusi_daerah_table.php`
*   **Perintah Commit**:
    ```bash
    git add database/migrations/*_create_poin_kontribusi_daerah_table.php
    git commit -m "SIGAP-77"
    ```


### 3. Commit Ketiga: Membuat Model PoinKontribusiDaerah & Relasi Daerah
*   **JIRA Task ID**: `SIGAP-78`
*   **File yang Dibuat/Diubah**:
    - `app/Models/PoinKontribusiDaerah.php`
    - `app/Models/Daerah.php`
*   **Perintah Commit**:
    ```bash
    git add app/Models/PoinKontribusiDaerah.php app/Models/Daerah.php
    git commit -m "SIGAP-78"
    ```

### 4. Commit Keempat: Membuat LeaderboardController
*   **JIRA Task ID**: `SIGAP-79`
*   **File yang Dibuat**: `app/Http/Controllers/LeaderboardController.php`
*   **Perintah Commit**:
    ```bash
    git add app/Http/Controllers/LeaderboardController.php
    git commit -m "SIGAP-79"
    ```

### 5. Commit Kelima: Integrasi Pemberian Poin Otomatis
*   **JIRA Task ID**: `SIGAP-8`
*   **File yang Diubah**:
    - `app/Http/Controllers/LaporanController.php`
    - `app/Http/Controllers/AuditFisikController.php`
*   **Perintah Commit**:
    ```bash
    git add app/Http/Controllers/LaporanController.php app/Http/Controllers/AuditFisikController.php
    git commit -m "SIGAP-80"
    ```

### 6. Commit Keenam: Registrasi Rute Web Leaderboard (Routes)
*   **JIRA Task ID**: `SIGAP-81`
*   **File yang Diubah**: `routes/web.php`
*   **Perintah Commit**:
    ```bash
    git add routes/web.php
    git commit -m "SIGAP-81"
    ```

### 7. Commit Ketujuh: Membuat View Publik Leaderboard (Blade View)
*   **JIRA Task ID**: `SIGAP-82`
*   **File yang Dibuat**: `resources/views/leaderboard/index.blade.php`
*   **Perintah Commit**:
    ```bash
    git add resources/views/leaderboard/index.blade.php
    git commit -m "SIGAP-82"
    ```

### 8. Commit Kedelapan: Membuat View Dashboard Admin Poin (Blade View)
*   **JIRA Task ID**: `SIGAP-83`
*   **File yang Dibuat**: `resources/views/admin/leaderboard/index.blade.php`
*   **Perintah Commit**:
    ```bash
    git add resources/views/admin/leaderboard/index.blade.php
    git commit -m "SIGAP-83"
    ```

### 9. Commit Kesembilan: Integrasi Menu Navigasi Landing Page & Sidebar Layout
*   **JIRA Task ID**: `SIGAP-84`
*   **File yang Diubah**:
    - `resources/views/welcome.blade.php`
    - `resources/views/admin/layout.blade.php`
*   **Perintah Commit**:
    ```bash
    git add resources/views/welcome.blade.php resources/views/admin/layout.blade.php
    git commit -m "SIGAP-84"
    ```


## 🔍 Lokasi Kode & Penanda Komentar
Seluruh perubahan kode Anda telah dibungkus dengan komentar penanda berikut untuk memudahkan proses audit:
```php
// =========================================================
// SPRINT 4 - FEATURE 6: Leaderboard & Poin Daerah [Dev 6]
// =========================================================
... kode milik Anda ...
// =========================================================
```
Pastikan komentar ini tetap ada saat Anda melakukan push ke repositori GitHub utama kelompok. Selamat bekerja!
