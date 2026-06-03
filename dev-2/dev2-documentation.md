# Panduan Implementasi JIRA & Git Commit - Developer 2
**Fitur: Modul Generator Ekspor Laporan (PDF & Excel)**

Panduan ini disusun untuk memudahkan Anda melakukan pemindahan kode (copy-paste) ke perangkat lokal Anda, serta melakukan Git Commit secara bertahap agar riwayat kontribusi Anda di GitHub terlihat produktif dan rapi sesuai pembagian kartu JIRA.

---

## 📅 Target Daily Report (JIRA)
> [!IMPORTANT]
> - Lakukan **Daily Report** di grup koordinasi Anda setiap kali Anda menyelesaikan **minimal 2 kali commit**.
> - Contoh laporan harian: *"Hari ini telah menyelesaikan JIRA task (SIGAP-49) dan (SIGAP-50) untuk modul Generator Ekspor Laporan."*

---

## 🛠️ Tahapan Git Commit (5 Commits)

Silakan lakukan copy-paste kode dan lakukan commit satu per satu dengan mengikuti instruksi di bawah ini:

### 1. Commit Pertama: Membuat LaporanEksporController
*   **JIRA Task ID**: `SIGAP-50`
*   **File yang Dibuat**: `app/Http/Controllers/LaporanEksporController.php`
*   **Perintah Commit**:
    ```bash
    git add app/Http/Controllers/LaporanEksporController.php
    git commit -m "SIGAP-50"
    ```

### 2. Commit Kedua: Registrasi Rute Web (Routes)
*   **JIRA Task ID**: `SIGAP-51`
*   **File yang Diubah**: `routes/web.php`
*   **Perintah Commit**:
    ```bash
    git add routes/web.php
    git commit -m "SIGAP-51"
    ```

### 3. Commit Ketiga: Halaman Filter Ekspor (Blade View)
*   **JIRA Task ID**: `SIGAP-52`
*   **File yang Dibuat**: `resources/views/admin/ekspor/indeks.blade.php`
*   **Perintah Commit**:
    ```bash
    git add resources/views/admin/ekspor/indeks.blade.php
    git commit -m "SIGAP-52"
    ```

### 4. Commit Keempat: Template Cetak PDF (Blade View)
*   **JIRA Task ID**: `SIGAP-53`
*   **File yang Dibuat**: `resources/views/admin/ekspor/pdf_template.blade.php`
*   **Perintah Commit**:
    ```bash
    git add resources/views/admin/ekspor/pdf_template.blade.php
    git commit -m "SIGAP-53"
    ```

### 5. Commit Kelima: Update Menu Sidebar Admin (Blade View Layout)
*   **JIRA Task ID**: `SIGAP-54`
*   **File yang Diubah**: `resources/views/admin/layout.blade.php`
*   **Perintah Commit**:
    ```bash
    git add resources/views/admin/layout.blade.php
    git commit -m "SIGAP-54"
    ```

---

## 🔍 Lokasi Kode & Penanda Komentar
Seluruh perubahan kode Anda telah dibungkus dengan komentar penanda berikut untuk memudahkan proses audit:
```php
// =========================================================
// SPRINT 4 - FEATURE 2: Ekspor Laporan [Dev 2]
// =========================================================
... kode milik Anda ...
// =========================================================
```
Pastikan komentar ini tetap ada saat Anda melakukan push ke repositori GitHub utama kelompok. Selamat bekerja!
