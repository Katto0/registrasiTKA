# Rencana Pemulihan Sidebar & Layout

Ternyata file layout utama `layouts/app.blade.php` belum memiliki struktur sidebar sama sekali (hanya kerangka HTML kosong). Sidebar yang Anda lihat sebelumnya mungkin di-hardcode di view `dashboard.blade.php` yang lama, dan hilang saat saya me-refresh view tersebut.

Kita akan memperbaikinya dengan **cara yang benar dan modular**:

1.  **Buat Layout Admin yang Proper**:
    Layout ini akan memiliki:
    *   **Sidebar Kiri (Fixed):** Berisi menu navigasi (Dashboard, Registrations, Users, Logout).
    *   **Konten Kanan (Scrollable):** Area dinamis untuk menampilkan halaman yang aktif.

2.  **Langkah Teknis**:
    *   Update `resources/views/layouts/app.blade.php`.
    *   Tambahkan struktur Flexbox/Grid:
        *   `<aside>` untuk Sidebar.
        *   `<main>` untuk Konten Utama dengan margin kiri agar tidak tertutup sidebar.
    *   Implementasikan styling Sidebar (Logo, Menu Items, Tombol Logout di bawah).

Dengan cara ini, sidebar akan otomatis muncul di **SEMUA** halaman (Dashboard, Data Pendaftaran, Manajemen User) tanpa perlu copy-paste code di setiap file.

## Menu Sidebar
*   Dashboard (Icon Home)
*   Data Pendaftaran (Icon Table/List)
*   Manajemen Pengguna (Icon User/Group)
*   Logout (Icon Log-out) - Posisi di bawah
