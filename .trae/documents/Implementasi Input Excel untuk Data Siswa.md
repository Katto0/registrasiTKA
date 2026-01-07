# Rencana Implementasi Input Data Siswa via Excel

Untuk memenuhi kebutuhan input data siswa melalui Excel, kita akan melakukan langkah-langkah berikut:

1.  **Instalasi Library Excel**: Kita akan menggunakan `maatwebsite/excel` (standar de-facto Laravel) untuk mempermudah pembuatan template dan pembacaan file Excel.
2.  **Pembuatan Template Excel**:
    *   Membuat class Export `StudentTemplateExport` yang mendefinisikan header kolom sesuai validasi backend: `nisn`, `fname`, `tanggal_lahir`, `tempat_lahir`, `jenis_kelamin`, `nama_orangtua`, `nomor_orangtua`.
    *   Menambahkan 1 baris dummy data sebagai contoh pengisian.
3.  **Route Download Template**:
    *   Menambahkan endpoint `GET /api/students/template` di `routes/web.php` agar FE bisa mengunduh template tersebut.
4.  **Update Controller untuk Import**:
    *   Memodifikasi `RegistrationController` (atau menambah method baru) untuk menangani upload file Excel.
    *   Melakukan parsing file Excel, memvalidasi setiap baris, dan menyimpannya ke database sebagai data `Student`.
    *   *Catatan:* Sesuai instruksi "inputnya melalui excel", maka input manual siswa di JSON sebelumnya akan digantikan (atau dijadikan opsional) dengan upload file ini.

## Langkah Teknis:
1.  Install `maatwebsite/excel`.
2.  Buat `App\Exports\StudentTemplateExport`.
3.  Buat `App\Imports\StudentsImport` (untuk logic parsing & validasi).
4.  Update `RegistrationController`:
    *   Tambah method `downloadTemplate()`.
    *   Update method `store()` untuk menerima file `student_file` dan menggunakan `StudentsImport` untuk memprosesnya.
5.  Update `routes/web.php`.
