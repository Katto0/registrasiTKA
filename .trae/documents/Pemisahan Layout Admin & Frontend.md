# Pemisahan Layout Admin (CMS) dan Frontend (FE)

Maaf atas kekeliruan tersebut. Anda benar, `layouts/app.blade.php` biasanya digunakan oleh semua halaman, sehingga jika sidebar ditaruh di sana, halaman FE juga akan kena dampaknya.

Solusinya adalah **memisahkan layout**:

1.  **Layout Frontend (`layouts/app.blade.php`):**
    *   Kita kembalikan seperti semula (clean, tanpa sidebar).
    *   Digunakan oleh halaman Login dan Form Pendaftaran (FE).

2.  **Layout Admin (`layouts/admin.blade.php`):**
    *   Kita buat file layout baru khusus CMS.
    *   Pindahkan kode Sidebar + Main Content ke sini.
    *   Digunakan oleh `Dashboard`, `Registrations`, dan `UserManagement`.

## Langkah Eksekusi
1.  **Revert** `layouts/app.blade.php` ke versi polos.
2.  **Buat** `layouts/admin.blade.php` dengan kode sidebar yang tadi saya buat.
3.  **Update** Component Livewire (`Dashboard.php`, `Registrations.php`, `UserManagement.php`) agar menggunakan `#[Layout('layouts.admin')]`.
