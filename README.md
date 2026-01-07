# 🏫 Aplikasi Registrasi TKA (Tes Kemampuan Akademik)

Selamat datang di repositori Aplikasi Registrasi TKA. Aplikasi ini dibangun menggunakan framework **Laravel** dan dirancang untuk memudahkan proses pendaftaran sekolah, operator, dan siswa peserta TKA.

![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)
![Livewire](https://img.shields.io/badge/Livewire-4E56A6?style=for-the-badge&logo=livewire&logoColor=white)

---

## 📖 Dokumentasi API (Untuk Frontend)

Bagi tim Frontend yang ingin mengintegrasikan aplikasi dengan backend kami, silakan merujuk ke dokumentasi lengkap API di bawah ini:

👉 **[BACA DOKUMENTASI BACKEND (backend.md)](backend.md)**

Dokumentasi tersebut mencakup:
- Daftar Endpoint API (Download Template, Pencarian Sekolah, Submit Pendaftaran).
- Format Request & Response (JSON).
- Contoh penggunaan.
- Catatan penting terkait CSRF dan Upload File.

---

## 🚀 Fitur Utama

- **Pendaftaran Sekolah & Operator:** Input data sekolah dan operator pendamping secara lengkap.
- **Import Data Siswa:** Upload data siswa secara massal menggunakan template Excel.
- **Validasi Data:** Pengecekan duplikasi NPSN dan validasi format file.
- **Dashboard Admin:**
  - Melihat daftar sekolah terdaftar.
  - Filter berdasarkan Jenjang (SD/SMP).
  - Pencarian real-time (Sekolah, NPSN, Operator).
  - **Export Laporan Excel** sesuai filter yang dipilih.
- **Responsive Design:** Tampilan optimal di Desktop, Tablet, dan Mobile.

---

## 🛠 Instalasi & Menjalankan Project

Ikuti langkah-langkah berikut untuk menjalankan project di lokal Anda:

1. **Clone Repositori**
   ```bash
   git clone https://github.com/username/registrasiTKA.git
   cd registrasiTKA
   ```

2. **Install Dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Setup Environment**
   Salin file `.env.example` menjadi `.env` dan sesuaikan konfigurasi database.
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Migrasi & Seeding Database**
   ```bash
   php artisan migrate --seed
   ```

5. **Jalankan Aplikasi**
   Buka dua terminal terpisah untuk menjalankan server PHP dan Vite (untuk aset frontend).
   
   *Terminal 1:*
   ```bash
   php artisan serve
   ```
   
   *Terminal 2:*
   ```bash
   npm run dev
   ```

6. **Akses Aplikasi**
   Buka browser dan kunjungi `http://localhost:8000`.

---

## 🧪 Menjalankan Testing

Kami telah menyediakan automated testing untuk memastikan fitur berjalan dengan baik.

```bash
php artisan test
```

Ini akan menjalankan pengujian untuk:
- Download template Excel.
- Proses submit pendaftaran (valid & invalid).
- Validasi data.

---

**Dibuat dengan ❤️ untuk kemajuan pendidikan.**
