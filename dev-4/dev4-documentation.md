# Panduan Implementasi JIRA & Git Commit - Developer 4
**Fitur: Modul Asisten AI Keputusan Admin (Analisis Anggaran & Prioritas)**

Panduan ini disusun untuk memudahkan Anda melakukan pemindahan kode (copy-paste) ke perangkat lokal Anda, serta melakukan Git Commit secara bertahap agar riwayat kontribusi Anda di GitHub terlihat produktif dan rapi sesuai pembagian kartu JIRA.

---

## 📅 Target Daily Report (JIRA)
> [!IMPORTANT]
> - Lakukan **Daily Report** di grup koordinasi Anda setiap kali Anda menyelesaikan **minimal 2 kali commit**.
> - Contoh laporan harian: *"Hari ini telah menyelesaikan JIRA task (SIGAP-61) dan (SIGAP-62) untuk modul Asisten AI Keputusan Admin."*

---

## 🛠️ Tahapan Git Commit (7 Commits)

Silakan lakukan copy-paste kode dan lakukan commit satu per satu dengan mengikuti instruksi di bawah ini:

### 1. Commit Pertama: Membuat AdminDecisionService
*   **JIRA Task ID**: `SIGAP-62`
*   **File yang Dibuat**: `app/Services/AdminDecisionService.php`
*   **Perintah Commit**:
    ```bash
    git add app/Services/AdminDecisionService.php
    git commit -m "SIGAP-62"
    ```

### 2. Commit Kedua: Membuat AdminChatbotController
*   **JIRA Task ID**: `SIGAP-63`
*   **File yang Dibuat**: `app/Http/Controllers/AdminChatbotController.php`
*   **Perintah Commit**:
    ```bash
    git add app/Http/Controllers/AdminChatbotController.php
    git commit -m "SIGAP-63"
    ```

### 3. Commit Ketiga: Registrasi Rute Web (Routes)
*   **JIRA Task ID**: `SIGAP-64`
*   **File yang Diubah**: `routes/web.php`
*   **Perintah Commit**:
    ```bash
    git add routes/web.php
    git commit -m "SIGAP-64"
    ```

### 4. Commit Keempat: Membuat Dashboard Asisten AI (Blade View)
*   **JIRA Task ID**: `SIGAP-65`
*   **File yang Dibuat**: `resources/views/admin/asisten-ai/index.blade.php`
*   **Perintah Commit**:
    ```bash
    git add resources/views/admin/asisten-ai/index.blade.php
    git commit -m "SIGAP-65"
    ```

### 5. Commit Kelima: Menambahkan Tombol Analisis AI di Detail Laporan (Blade View)
*   **JIRA Task ID**: `SIGAP-66`
*   **File yang Diubah**: `resources/views/admin/laporan/detail.blade.php`
*   **Perintah Commit**:
    ```bash
    git add resources/views/admin/laporan/detail.blade.php
    git commit -m "SIGAP-66"
    ```

### 6. Commit Keenam: Menambahkan Menu Navigasi Sidebar (Blade View)
*   **JIRA Task ID**: `SIGAP-67`
*   **File yang Diubah**: `resources/views/admin/layout.blade.php`
*   **Perintah Commit**:
    ```bash
    git add resources/views/admin/layout.blade.php
    git commit -m "SIGAP-67"
    ```

---

## 🔍 Lokasi Kode & Penanda Komentar
Seluruh perubahan kode Anda telah dibungkus dengan komentar penanda berikut untuk memudahkan proses audit:
```php
// =========================================================
// SPRINT 4 - FEATURE 4: Asisten AI Keputusan Admin [Dev 4]
// =========================================================
... kode milik Anda ...
// =========================================================
```
Pastikan komentar ini tetap ada saat Anda melakukan push ke repositori GitHub utama kelompok. Selamat bekerja!
