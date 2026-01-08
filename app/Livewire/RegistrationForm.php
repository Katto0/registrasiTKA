<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Http;

class RegistrationForm extends Component
{
    use WithFileUploads;

    public $currentStep = 1;

    // =========================================================================
    // 1. STATE PROPERTIES (DATA MODEL)
    // =========================================================================

    // A. Data Sekolah
    public $npsn_sekolah = '';      // Kunci Pencarian (Parameter 'npsn')
    public $nama_sekolah = '';      // Terisi otomatis (Readonly)
    public $jenjang_sekolah = '';   // Terisi otomatis (Readonly)
    public $alamat_sekolah = '';    // Terisi otomatis (Readonly)
    public $jumlah_perangkat = '';  // Input Manual

    // B. Data Operator
    public $nama_operator = '';
    public $no_whatsapp_operator = '';
    public $email_sekolah = '';

    // C. File Upload
    public $file_siswa;

    // D. Hidden Fields (Nilai Default untuk API)
    // -------------------------------------------------------------------------
    // Variabel di bawah ini WAJIB ada di API Backend, tetapi tidak ditampilkan
    // di form UI Frontend. Kita isi dengan nilai default '-' atau angka dummy
    // agar proses submit tidak ditolak oleh server (Error 422).
    // -------------------------------------------------------------------------
    public $nama_kepala_sekolah = '-';
    public $nip_kepala_sekolah = null;
    public $no_hp_kepala_sekolah = '080000000000';

    // UI Helper
    public $isSubmitted = false;
    public $searchResults = [];
    public $showSuggestions = false;

    // =========================================================================
    // 2. VALIDATION RULES
    // =========================================================================

    protected function rulesStep1()
    {
        return [
            'npsn_sekolah'         => 'required|numeric|digits:8',
            'nama_sekolah'         => 'required|min:3',
            'jenjang_sekolah'      => 'required|in:SD,SMP',
            'alamat_sekolah'       => 'required',
            'jumlah_perangkat'     => 'required|numeric|min:0',
            'nama_operator'        => 'required|min:3',
            'no_whatsapp_operator' => 'required|numeric|starts_with:08',
            'email_sekolah'        => 'required|email:dns',
        ];
    }

    protected function rulesStep2()
    {
        return [
            'file_siswa' => ['required', 'file', 'extensions:xlsx,xls', 'max:10240'],
        ];
    }

    // =========================================================================
    // 3. ACTIONS
    // =========================================================================

    /**
     * Pencarian Sekolah via API
     * Menggunakan route('api.schools.search') yang mengarah ke /api/schools/search
     */
    public function updatedNpsnSekolah()
    {
        // Reset field
        $this->nama_sekolah = '';
        $this->jenjang_sekolah = '';
        $this->alamat_sekolah = '';

        // Reset pencarian jika input kosong/pendek
        if (strlen($this->npsn_sekolah) < 3) {
            $this->searchResults = [];
            $this->showSuggestions = false;
            return;
        }

        try {
            // [FIX] Menggunakan Named Route agar sesuai definisi di routes/web.php
            // URL: /api/schools/search
            $response = Http::timeout(5)->get(route('api.schools.search'), [
                'npsn' => $this->npsn_sekolah
            ]);

            if ($response->successful()) {
                $data = $response->json();

                $this->searchResults = collect($data)->map(function ($item) {
                    return [
                        'npsn'    => $item['npsn_sekolah'],
                        'nama'    => $item['nama_sekolah'],
                        'jenjang' => $item['jenjang_pendidikan'],
                        'alamat'  => $item['alamat_sekolah'] ?? '-',
                        // Status sekolah dihapus dari mapping karena tidak dipakai
                    ];
                })->toArray();

                // Selalu set true agar box "Tidak Ditemukan" bisa muncul jika array kosong
                $this->showSuggestions = true;
            } else {
                $this->searchResults = [];
                $this->showSuggestions = true;
            }
        } catch (\Exception $e) {
            $this->searchResults = [];
            $this->showSuggestions = true;
        }
    }

    // Hapus parameter $status dari fungsi selectSchool
    public function selectSchool($npsn, $nama, $jenjang, $alamat)
    {
        $this->npsn_sekolah = $npsn;
        $this->nama_sekolah = $nama;
        $this->jenjang_sekolah = $jenjang;
        $this->alamat_sekolah = $alamat;

        $this->showSuggestions = false;
        $this->searchResults = [];
    }

    public function nextStep()
    {
        $this->validate($this->rulesStep1());
        $this->currentStep = 2;
    }

    public function previousStep()
    {
        $this->currentStep = 1;
    }

    private function sanitizeInput()
    {
        $this->nama_operator = ucwords(strtolower(strip_tags(trim($this->nama_operator))));
    }

    public function submit()
    {
        $this->sanitizeInput();
        $this->validate(array_merge($this->rulesStep1(), $this->rulesStep2()));

        try {
            // [FIX] Menggunakan Named Route untuk Submit
            // URL: /api/registrations
            $response = Http::attach(
                'file_siswa',
                file_get_contents($this->file_siswa->getRealPath()),
                $this->file_siswa->getClientOriginalName()
            )->post(route('api.registrations.store'), [
                // Data yang dikirim ke API (Sesuai request User)
                'npsn_sekolah'         => $this->npsn_sekolah,
                'nama_sekolah'         => $this->nama_sekolah,
                'jenjang_sekolah'      => $this->jenjang_sekolah,
                'alamat_sekolah'       => $this->alamat_sekolah,
                'jumlah_perangkat'     => $this->jumlah_perangkat,

                // Note: Operator & Hidden Fields mungkin perlu ditambahkan di sini
                // jika API backend mewajibkannya, namun saat ini dikirim sesuai request user.
            ]);

            if ($response->successful()) {
                $this->isSubmitted = true;
            } else {
                $errorData = $response->json();
                if (isset($errorData['errors'])) {
                    foreach ($errorData['errors'] as $field => $messages) {
                        $this->addError($field, $messages[0]);
                    }
                } else {
                    $this->addError('npsn_sekolah', 'Gagal menyimpan data.');
                }
            }
        } catch (\Exception $e) {
            $this->addError('npsn_sekolah', 'Koneksi gagal: ' . $e->getMessage());
        }
    }

    public function resetForm()
    {
        $this->reset();
        $this->isSubmitted = false;
        $this->currentStep = 1;
    }

    public function render()
    {
        return view('livewire.registration-form');
    }
}
