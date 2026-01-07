# 📚 Backend API Documentation

Dokumentasi ini ditujukan untuk tim Frontend (FE) agar dapat mengintegrasikan antarmuka pengguna dengan backend Registrasi TKA secara benar dan efisien.

## 🔗 Base URL
Semua endpoint API berada di bawah path:
`http://registrasitka.test/api`

---

## 🚀 Endpoints

### 1. Download Template Excel Siswa
Digunakan untuk mengunduh template Excel yang harus diisi oleh sekolah/operator untuk mendaftarkan siswa.

- **Method:** `GET`
- **URL:** `/api/students/template`
- **Response:** File download `.xlsx`
- **Contoh Penggunaan (JS):**
  ```javascript
  window.location.href = '/api/students/template';
  ```

### 2. Cari Sekolah (Autocomplete)
Digunakan untuk mencari data sekolah berdasarkan Nama atau NPSN. Berguna untuk form autocomplete saat registrasi.

- **Method:** `GET`
- **URL:** `/api/schools/search`
- **Query Params:**
  - `query`: String pencarian (minimal 3 karakter disarankan)
- **Response Success (200 OK):**
  ```json
  [
    {
      "id": 1,
      "nama_sekolah": "SD NEGERI 1 CONTOH",
      "npsn_sekolah": "12345678",
      "jenjang_pendidikan": "SD",
    },
    ...
  ]
  ```

### 3. Submit Pendaftaran Baru
Endpoint utama untuk mengirimkan data pendaftaran sekolah, operator, dan upload data siswa.

- **Method:** `POST`
- **URL:** `/api/registrations`
- **Content-Type:** `multipart/form-data` (Wajib karena ada upload file)
- **Body Parameters:**

  | Parameter | Tipe | Wajib | Keterangan |
  |-----------|------|-------|------------|
  | `nama_sekolah` | String | Ya | Nama lengkap sekolah |
  | `npsn_sekolah` | String | Ya | Nomor Pokok Sekolah Nasional (8 digit) |
  | `jenjang_sekolah` | String | Ya | `SD` atau `SMP` |
  | `status_sekolah` | String | Ya | `negeri` atau `swasta` |
  | `alamat_sekolah` | String | Ya | Alamat lengkap sekolah |
  | `nama_kepala_sekolah` | String | Ya | Nama Kepala Sekolah |
  | `nip_kepala_sekolah` | String | Tidak | NIP (opsional untuk swasta) |
  | `no_hp_kepala_sekolah` | String | Ya | Nomor HP/WA aktif |
  | `nama_operator` | String | Ya | Nama Operator Sekolah |
  | `no_whatsapp_operator` | String | Ya | Nomor WA aktif operator |
  | `email_sekolah` | Email | Ya | Email resmi/aktif sekolah |
  | `jumlah_perangkat` | Integer | Ya | Jumlah perangkat TKA yang dimiliki |
  | `file_siswa` | File | Ya | File Excel template yang sudah diisi (`.xlsx`, `.xls`) |

- **Response Success (201 Created):**
  ```json
  {
    "message": "Pendaftaran berhasil disimpan.",
    "data": {
      "school_id": 15,
      "total_students": 120
    }
  }
  ```

- **Response Error Validation (422 Unprocessable Entity):**
  ```json
  {
    "message": "The given data was invalid.",
    "errors": {
      "npsn_sekolah": [
        "NPSN sekolah sudah terdaftar."
      ],
      "file_siswa": [
        "File siswa harus berupa file tipe: xlsx, xls."
      ]
    }
  }
  ```

---

## 🛠 Catatan Penting untuk FE

1. **CSRF Token:**
   Jika menggunakan Laravel sebagai full-stack atau memanggil API dari domain yang sama, pastikan menyertakan `X-CSRF-TOKEN` di header atau meta tag.
   ```html
   <meta name="csrf-token" content="{{ csrf_token() }}">
   ```

2. **Handling File Upload:**
   Saat mengirim data ke `/api/registrations`, jangan lupa gunakan `FormData` object di JavaScript agar file terkirim dengan benar.
   ```javascript
   const formData = new FormData();
   formData.append('file_siswa', fileInput.files[0]);
   formData.append('nama_sekolah', 'SD Contoh');
   // ... append data lainnya
   
   axios.post('/api/registrations', formData, {
       headers: {
           'Content-Type': 'multipart/form-data'
       }
   });
   ```

3. **Validasi Frontend:**
   Meskipun backend memiliki validasi, disarankan FE juga melakukan validasi dasar seperti:
   - Format email.
   - NPSN harus angka.
   - File yang diupload harus Excel.
