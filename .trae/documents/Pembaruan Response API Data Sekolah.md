# Rencana Pembaruan API Data Sekolah

Berdasarkan pengecekan respons API eksternal `https://sekolah.devapi.id/sekolah?npsn=...`, struktur datanya adalah:
```json
{
    "success": true,
    "data": [
        {
            "npsn": "10101691",
            "nama": "SD NEGERI 10 NISAM",
            "bentukPendidikan": "SD",
            ...
        }
    ]
}
```

Saya akan memodifikasi `SchoolController::search` untuk:
1.  Mengambil item pertama dari array `data`.
2.  Melakukan mapping field sesuai permintaan user:
    *   `nama_sekolah` <- `nama`
    *   `npsn_sekolah` <- `npsn`
    *   `jenjang_pendidikan` <- `bentukPendidikan`
3.  Mengembalikan JSON object tunggal yang sudah dibersihkan (bukan array dan bukan raw response).

## Langkah Teknis
1.  Update `app/Http/Controllers/SchoolController.php`:
    *   Parsing body response JSON.
    *   Cek apakah key `data` ada dan tidak kosong.
    *   Ambil index ke-0 dari `data`.
    *   Return JSON baru dengan key `nama_sekolah`, `npsn_sekolah`, dan `jenjang_pendidikan`.
