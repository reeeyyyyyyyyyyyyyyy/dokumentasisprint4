# Panduan Implementasi JIRA & Git Commit - Developer 3
**Fitur: Modul Asisten Virtual AI Warga (MinGAP)**

Panduan ini disusun untuk memudahkan Anda melakukan pemindahan kode (copy-paste) ke perangkat lokal Anda, serta melakukan Git Commit secara bertahap agar riwayat kontribusi Anda di GitHub terlihat produktif dan rapi sesuai pembagian kartu JIRA.

---

## 📅 Target Daily Report (JIRA)
> [!IMPORTANT]
> - Lakukan **Daily Report** di grup koordinasi Anda setiap kali Anda menyelesaikan **minimal 2 kali commit**.
> - Contoh laporan harian: *"Hari ini telah menyelesaikan JIRA task (SIGAP-55) dan (SIGAP-56) untuk modul Asisten Virtual AI Warga (MinGAP)."*

---

## 🛠️ Tahapan Git Commit (6 Commits)

Silakan lakukan copy-paste kode dan lakukan commit satu per satu dengan mengikuti instruksi di bawah ini:

### 1. Commit Pertama: Membuat MinGapAiService
*   **JIRA Task ID**: `SIGAP-56`
*   **File yang Dibuat**: `app/Services/MinGapAiService.php`
*   **Perintah Commit**:
    ```bash
    git add app/Services/MinGapAiService.php
    git commit -m "SIGAP-56"
    ```

### 2. Commit Kedua: Membuat MinGapChatbotController
*   **JIRA Task ID**: `SIGAP-57`
*   **File yang Dibuat**: `app/Http/Controllers/MinGapChatbotController.php`
*   **Perintah Commit**:
    ```bash
    git add app/Http/Controllers/MinGapChatbotController.php
    git commit -m "SIGAP-57"
    ```

### 3. Commit Ketiga: Registrasi Rute Web (Routes)
*   **JIRA Task ID**: `SIGAP-58`
*   **File yang Diubah**: `routes/web.php`
*   **Perintah Commit**:
    ```bash
    git add routes/web.php
    git commit -m "SIGAP-58"
    ```

### 4. Commit Keempat: Membuat Blade Component Chatbot Widget
*   **JIRA Task ID**: `SIGAP-59`
*   **File yang Dibuat**: `resources/views/components/chatbot-widget.blade.php`
*   **Perintah Commit**:
    ```bash
    git add resources/views/components/chatbot-widget.blade.php
    git commit -m "SIGAP-59"
    ```

### 5. Commit Kelima: Integrasi Widget di Halaman Depan Welcome
*   **JIRA Task ID**: `SIGAP-60`
*   **File yang Diubah**: `resources/views/welcome.blade.php`
*   **Perintah Commit**:
    ```bash
    git add resources/views/welcome.blade.php
    git commit -m "SIGAP-60"
    ```


## 🔍 Lokasi Kode & Penanda Komentar
Seluruh perubahan kode Anda telah dibungkus dengan komentar penanda berikut untuk memudahkan proses audit:
```php
// =========================================================
// SPRINT 4 - FEATURE 3: Asisten Virtual AI [Dev 3]
// =========================================================
... kode milik Anda ...
// =========================================================
```
Pastikan komentar ini tetap ada saat Anda melakukan push ke repositori GitHub utama kelompok. Selamat bekerja!
