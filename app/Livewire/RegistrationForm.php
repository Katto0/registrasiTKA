<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Http;

class RegistrationForm extends Component
{
    use WithFileUploads;

    public $currentStep = 1;
    public $isSubmitted = false;

    // --- STATE PROPERTIES ---

    // Data Sekolah
    public $npsn_sekolah = '';
    public $nama_sekolah = '';
    public $jenjang_sekolah = '';
    public $alamat_sekolah = '';
    public $jumlah_perangkat = '';

    // Data Operator
    public $nama_operator = '';
    public $no_whatsapp_operator = '';
    public $email_sekolah = '';

    // File Upload
    public $file_siswa;

    // Hidden Fields (Default API Requirement)
    public $status_sekolah = 'negeri';
    public $nama_kepala_sekolah = '-';
    public $nip_kepala_sekolah = null;
    public $no_hp_kepala_sekolah = '080000000000';

    // UI Helpers
    public $searchResults = [];
    public $showSuggestions = false;
    public $apiError = '';

    // [FIX] Menggunakan URL API Pasti (sesuai yang Anda cek berjalan)
    // Jika di localhost biasa error, ganti ke url('/api') jika perlu.
    protected $apiBaseUrl = 'http://registrasitka.test/api';

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
    // 3. PUBLIC ACTIONS
    // =========================================================================

    public function updatedNpsnSekolah()
    {
        $this->sanitizeNpsn();
        $this->resetAutoFields();

        // Validasi real-time untuk feedback user
        $length = strlen($this->npsn_sekolah);
        
        if ($length > 0 && $length < 8) {
            // Tampilkan error jika kurang dari 8 digit
            $this->addError('npsn_sekolah', 'NPSN harus 8 digit lengkap');
            $this->searchResults = [];
            $this->showSuggestions = false;
        } elseif ($length === 8) {
            // Hapus error jika sudah 8 digit lengkap
            $this->resetErrorBag('npsn_sekolah');
        }
    }

    public function searchSchool()
    {
        $this->sanitizeNpsn();

        // Validasi harus 8 digit penuh sebelum search
        if (strlen($this->npsn_sekolah) !== 8) {
            $this->addError('npsn_sekolah', 'NPSN harus 8 digit lengkap');
            $this->searchResults = [];
            $this->showSuggestions = false;
            return;
        }

        // Clear error dan lakukan pencarian
        $this->resetErrorBag('npsn_sekolah');
        $this->performSearch();
    }

    public function selectSchool($npsn, $nama, $jenjang, $alamat, $status)
    {
        $this->npsn_sekolah = $npsn;
        $this->nama_sekolah = $nama;
        $this->jenjang_sekolah = $jenjang;
        $this->alamat_sekolah = $alamat;
        $this->status_sekolah = $status;

        $this->closeSuggestions();
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

    public function submit()
    {
        $this->sanitizeTextInputs();
        $this->validate(array_merge($this->rulesStep1(), $this->rulesStep2()));

        try {
            // Build payload data
            $payload = $this->buildPayload();
            
            // Create HTTP request with multipart/form-data and CSRF token
            $request = Http::withoutVerifying()
                ->asMultipart()
                ->withHeaders([
                    'X-CSRF-TOKEN' => csrf_token(),
                    'Accept' => 'application/json',
                ]);
            
            // Attach the file
            $request->attach(
                'student_file',  // API expects 'student_file' not 'file_siswa'
                file_get_contents($this->file_siswa->getRealPath()),
                $this->file_siswa->getClientOriginalName()
            );
            
            // Send POST request with all form fields
            $response = $request->post($this->getEndpoint('registrations'), $payload);

            if ($response->successful()) {
                $this->isSubmitted = true;
                session()->flash('success', 'Pendaftaran berhasil dikirim!');
            } else {
                $this->handleApiError($response);
                session()->flash('error', 'Gagal mengirim data. Periksa kembali form Anda.');
            }
        } catch (\Exception $e) {
            $this->addError('npsn_sekolah', 'Koneksi gagal: ' . $e->getMessage());
            session()->flash('error', 'Koneksi ke server gagal. Coba lagi nanti.');
        }
    }

    public function resetForm()
    {
        $this->reset();
        $this->isSubmitted = false;
        $this->currentStep = 1;
    }

    // =========================================================================
    // 4. PRIVATE HELPERS
    // =========================================================================

    private function getEndpoint($path)
    {
        // Menggabungkan Base URL dengan endpoint
        return rtrim($this->apiBaseUrl, '/') . '/' . ltrim($path, '/');
    }

    private function sanitizeNpsn()
    {
        $this->npsn_sekolah = preg_replace('/[^0-9]/', '', $this->npsn_sekolah);
    }

    private function sanitizeTextInputs()
    {
        $this->nama_operator = ucwords(strtolower(strip_tags(trim($this->nama_operator))));
        $this->sanitizeNpsn();
    }

    private function resetAutoFields()
    {
        $this->nama_sekolah = '';
        $this->jenjang_sekolah = '';
        $this->alamat_sekolah = '';
        $this->apiError = '';
    }

    private function closeSuggestions()
    {
        $this->showSuggestions = false;
        $this->searchResults = [];
    }

    private function performSearch()
    {
        try {
            // [FIX] Menggunakan URL API Eksplisit
            $response = Http::timeout(5)
                ->withoutVerifying()
                ->acceptJson()
                ->get($this->getEndpoint('schools/search'), [
                    'npsn' => $this->npsn_sekolah
                ]);

            if ($response->successful()) {
                $this->processSearchResults($response->json());
            } else {
                // API Error (404/500)
                $this->searchResults = [];
                $this->showSuggestions = true;
            }
        } catch (\Exception $e) {
            // Error Koneksi
            $this->searchResults = [];
            $this->showSuggestions = true;
        }
    }

    private function processSearchResults($rawData)
    {
        // 1. Normalisasi Wrapper 'data'
        $data = $rawData['data'] ?? $rawData;

        // 2. [FIX] Deteksi Objek Tunggal vs Array
        // Jika array kosong, atau bukan array, return kosong
        if (empty($data) || !is_array($data)) {
            $this->searchResults = [];
            $this->showSuggestions = true;
            return;
        }

        // Cek apakah ini Array Asosiatif (Objek Tunggal)
        // Ciri: Key-nya string (misal "nama_sekolah"), bukan index angka (0, 1, 2)
        $isAssociative = count(array_filter(array_keys($data), 'is_string')) > 0;

        if ($isAssociative) {
            // Bungkus objek tunggal ke dalam array agar bisa di-looping
            $data = [$data];
        }

        // 3. Mapping Data
        $this->searchResults = collect($data)->map(function ($item) {
            return [
                'npsn_sekolah'       => $item['npsn_sekolah'] ?? $item['npsn'] ?? '-',
                'nama_sekolah'       => $item['nama_sekolah'] ?? $item['nama'] ?? '-',
                'jenjang_pendidikan' => $item['jenjang_pendidikan'] ?? $item['jenjang'] ?? '-',
                'alamat_sekolah'     => $item['alamat_sekolah'] ?? $item['alamat'] ?? '-',
                'status_sekolah'     => $item['status_sekolah'] ?? $item['status'] ?? 'negeri',
            ];
        })->toArray();

        $this->showSuggestions = true;
    }

    private function buildPayload()
    {
        return [
            'npsn_sekolah'         => $this->npsn_sekolah,
            'nama_sekolah'         => $this->nama_sekolah,
            'jenjang_pendidikan'   => $this->jenjang_sekolah,  // API expects 'jenjang_pendidikan'
            'alamat_sekolah'       => $this->alamat_sekolah ?: '-',
            'jumlah_perangkat'     => $this->jumlah_perangkat,
            'nama_operator'        => $this->nama_operator,
            'no_whatsapp'          => $this->no_whatsapp_operator,  // API expects 'no_whatsapp'
            'email_sekolah'        => $this->email_sekolah,
            'status_sekolah'       => $this->status_sekolah,
            'nama_kepala_sekolah'  => $this->nama_kepala_sekolah,
            'nip_kepala_sekolah'   => $this->nip_kepala_sekolah ?: '',
            'no_hp_kepala_sekolah' => $this->no_hp_kepala_sekolah,
        ];
    }

    private function handleApiError($response)
    {
        $errorData = $response->json();
        
        // DEBUG: Log full response for troubleshooting
        \Log::error('API Error Response', [
            'status' => $response->status(),
            'body' => $response->body(),
            'json' => $errorData
        ]);
        
        if (isset($errorData['errors'])) {
            foreach ($errorData['errors'] as $field => $messages) {
                $this->addError($field, is_array($messages) ? $messages[0] : $messages);
            }
        } elseif (isset($errorData['message'])) {
            // Tampilkan message dari API
            $this->addError('npsn_sekolah', $errorData['message']);
        } else {
            // Fallback error dengan status code
            $this->addError('npsn_sekolah', 'Gagal menyimpan data. (HTTP ' . $response->status() . ')');
        }
    }

    public function render()
    {
        return view('livewire.registration-form');
    }
}
