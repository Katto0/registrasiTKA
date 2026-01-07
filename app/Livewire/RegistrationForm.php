<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Validation\Rule;

class RegistrationForm extends Component
{
    use WithFileUploads;

    // =========================================================================
    // 1. STATE PROPERTIES (DATA MODEL)
    // =========================================================================

    // A. Data Siswa (File Upload)
    public $studentFile;

    // B. Data Sekolah
    public $schoolLevel = ''; // 'SD' atau 'SMP'
    public $grade = '';       // '6' atau '9' (Auto-filled)
    public $npsn = '';
    public $schoolName = '';

    // C. Data Operator (Pelapor)
    public $operatorName = '';
    public $phoneNumber = '';
    public $email = '';

    // D. UI State
    public $isSubmitted = false;

    // =========================================================================
    // 2. CONFIGURATION & HELPERS
    // =========================================================================

    /**
     * Mengambil daftar kelas yang valid berdasarkan jenjang.
     * Digunakan di: rules() dan render().
     */
    private function getGradesByLevel(): array
    {
        return match($this->schoolLevel) {
            'SD'  => ['6'],
            'SMP' => ['9'],
            default => []
        };
    }

    // =========================================================================
    // 3. VALIDATION RULES
    // =========================================================================

    protected function rules()
    {
        return [
            // Validasi File: Wajib Excel/CSV, Max 10MB
            'studentFile' => [
                'required',
                'file',
                'extensions:xlsx,xls,csv',
                'max:10240'
            ],

            // Validasi Data Sekolah
            'schoolName'  => ['required', 'min:3', 'max:200', 'regex:/^[a-zA-Z0-9\s\.\,\-\(\)]+$/'],
            'npsn'        => 'required|numeric|digits:8',
            'schoolLevel' => 'required|in:SD,SMP',
            'grade'       => ['required', Rule::in($this->getGradesByLevel())],

            // Validasi Data Operator
            'operatorName'=> ['required', 'min:3', 'max:100', 'regex:/^[a-zA-Z\s\.\,\-\']+$/'],
            'phoneNumber' => ['required', 'numeric', 'digits_between:10,15', 'starts_with:08'],
            'email'       => 'required|email:dns,rfc|max:255',
        ];
    }

    protected $messages = [
        'studentFile.required'   => 'Mohon unggah file Excel data siswa.',
        'studentFile.extensions' => 'Format file harus .xlsx, .xls, atau .csv.',
        'studentFile.max'        => 'Ukuran file terlalu besar (Maksimal 10MB).',
        'numeric'                => 'Hanya boleh diisi angka.',
        'starts_with'            => 'Nomor harus diawali 08.',
    ];

    // =========================================================================
    // 4. LIFECYCLE & EVENT HANDLERS
    // =========================================================================

    /**
     * UX FEATURE: Auto-Fill Kelas.
     * Dijalankan otomatis oleh Livewire saat user mengubah dropdown 'schoolLevel'.
     */
    public function updatedSchoolLevel()
    {
        $this->grade = ''; // Reset nilai lama

        // Set otomatis kelas akhir
        if ($this->schoolLevel === 'SD') {
            $this->grade = '6';
        } elseif ($this->schoolLevel === 'SMP') {
            $this->grade = '9';
        }
    }

    // =========================================================================
    // 5. SUBMIT ACTIONS
    // =========================================================================

    /**
     * Membersihkan input string dari tag HTML berbahaya (Sanitasi).
     */
    private function sanitizeInput()
    {
        $this->schoolName = strtoupper(strip_tags(trim($this->schoolName)));
        $this->operatorName = ucwords(strtolower(strip_tags(trim($this->operatorName))));
    }

    /**
     * Handler utama saat tombol Submit ditekan.
     */
    public function submit()
    {
        // 1. Sanitasi Data Input
        $this->sanitizeInput();

        // 2. Jalankan Validasi (Sesuai rules di atas)
        $this->validate();

        /*
         * --------------------------------------------------------------------------
         * BACKEND DEVELOPER - IMPLEMENTASI DATABASE DI SINI
         * --------------------------------------------------------------------------
         */

        // Simulasi loading proses (hapus saat production)
        sleep(2);

        // Ubah state UI menjadi sukses
        $this->isSubmitted = true;
    }

    public function resetForm()
    {
        $this->reset();
        $this->isSubmitted = false;
    }

    public function render()
    {
        return view('livewire.registration-form', [
            // Kirim data kelas ke view menggunakan helper agar konsisten
            'availableGrades' => $this->getGradesByLevel()
        ]);
    }
}
