# Rencana Implementasi Backend Registrasi TKA

Sesuai permintaan Anda, kita akan fokus pada sisi **Backend** dan **CMS**, menyiapkan struktur data, API, dan Controller tanpa mengubah tampilan `registration-form`.

## 1. Struktur Database & Model
Kita akan membuat 3 tabel terpisah yang saling berelasi untuk normalisasi data yang baik:
*   **Table `schools`** (Data Sekolah)
    *   `nama_sekolah` (string)
    *   `npsn_sekolah` (string, unique index)
    *   `jenjang_pendidikan` (enum/string: SMP, SD)
    *   `jumlah_perangkat` (integer)
*   **Table `operators`** (Operator Sekolah)
    *   `school_id` (foreign key)
    *   `nama_operator` (string)
    *   `no_whatsapp` (string)
    *   `email_sekolah` (string, unique)
*   **Table `students`** (Data Siswa)
    *   `school_id` (foreign key)
    *   `nisn` (string, unique)
    *   `fname` (string)
    *   `tanggal_lahir` (date)
    *   `tempat_lahir` (string)
    *   `jenis_kelamin` (enum/string: L, P)
    *   `nama_orangtua` (string, nullable)
    *   `nomor_orangtua` (string, nullable)

## 2. API Data Sekolah (External Integration)
Kita akan membuat Controller untuk menangani pencarian data sekolah dari `sekolah.devapi.id`.
*   **Controller:** `App\Http\Controllers\Api\SchoolApiController`
*   **Method:** `search(Request $request)`
    *   Menerima parameter `npsn`.
    *   Melakukan HTTP Request ke `https://sekolah.devapi.id/sekolah?npsn={npsn}`.
    *   Mengembalikan response JSON yang diformat untuk kebutuhan FE.

## 3. Resource Controller (Penyimpanan Data)
Kita akan membuat Resource Controller untuk menangani submission form pendaftaran.
*   **Controller:** `App\Http\Controllers\RegistrationController`
*   **Method:** `store(Request $request)`
    *   Validasi input sesuai rules (required, unique, dll).
    *   Menggunakan `DB::Transaction` untuk memastikan integritas data:
        1.  Create/Update `School`.
        2.  Create `Operator`.
        3.  Create `Student`.
    *   Mengembalikan response JSON sukses.

## 4. Routes (web.php)
Kita akan menambahkan definisi route di `routes/web.php` dengan komentar yang jelas untuk tim FE.
*   `GET /api/schools/search` -> Untuk auto-complete data sekolah.
*   `POST /api/registrations` -> Untuk submit form pendaftaran.

## Langkah Eksekusi
1.  Buat Migration dan Model untuk `School`, `Operator`, `Student`.
2.  Jalankan `php artisan migrate`.
3.  Buat `SchoolApiController` dan implementasi logika fetch API.
4.  Buat `RegistrationController` dan implementasi logika `store`.
5.  Update `routes/web.php` dengan route baru dan komentar.
