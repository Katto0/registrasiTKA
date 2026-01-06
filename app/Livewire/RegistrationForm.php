<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Validation\Rule;

class RegistrationForm extends Component
{
    use WithFileUploads;

    // --- STATE ---
    public $studentFile;
    public $schoolLevel = '';
    public $grade = '';
    public $npsn = '';
    public $schoolName = '';
    public $operatorName = '';
    public $phoneNumber = '';
    public $email = '';
    public $isSubmitted = false;

    // --- CONFIG ---
    // Referensi header Excel untuk Backend Developer
    protected $expectedExcelHeaders = ['Nama Siswa', 'NISN', 'Tempat Lahir', 'Tanggal Lahir'];

    // --- VALIDATION ---
    protected function rules()
    {
        $validGrades = match($this->schoolLevel) {
            'SD' => ['1', '2', '3', '4', '5', '6'],
            'SMP' => ['7', '8', '9'],
            default => []
        };

        return [
            'studentFile' => ['required', 'file', 'extensions:xlsx,xls,csv', 'max:10240'],
            'schoolName'  => ['required', 'min:3', 'max:200', 'regex:/^[a-zA-Z0-9\s\.\,\-\(\)]+$/'],
            'npsn'        => 'required|numeric|digits:8',
            'schoolLevel' => 'required|in:SD,SMP',
            'grade'       => ['required', Rule::in($validGrades)],
            'operatorName'=> ['required', 'min:3', 'max:100', 'regex:/^[a-zA-Z\s\.\,\-\']+$/'],
            'phoneNumber' => ['required', 'numeric', 'digits_between:10,15', 'starts_with:08'],
            'email'       => 'required|email:dns,rfc|max:255',
        ];
    }

    protected $messages = [
        'studentFile.required' => 'Mohon unggah file Excel data siswa.',
        'numeric' => 'Hanya boleh diisi angka.',
    ];

    // --- AUTOMATION LOGIC ---

    /**
     * Fitur Otomatisasi:
     * Berjalan otomatis ketika user mengubah dropdown 'schoolLevel'.
     */
    public function updatedSchoolLevel()
    {
        // Reset dulu agar bersih
        $this->grade = '';

        // Otomatis pilih kelas akhir berdasarkan jenjang
        if ($this->schoolLevel === 'SD') {
            $this->grade = '6';
        } elseif ($this->schoolLevel === 'SMP') {
            $this->grade = '9';
        }
    }

    private function sanitizeInput()
    {
        $this->schoolName = strtoupper(strip_tags(trim($this->schoolName)));
        $this->operatorName = ucwords(strtolower(strip_tags(trim($this->operatorName))));
    }

    public function submit()
    {
        $this->sanitizeInput();
        $this->validate();

        // --- TODO: BACKEND DEVELOPER ---
        // 1. Simpan file: $path = $this->studentFile->store('uploads');
        // 2. Import Excel: Excel::import(new StudentsImport, $path);
        // 3. Simpan data operator & sekolah.

        sleep(2); // Simulasi loading
        $this->isSubmitted = true;
    }

    public function resetForm()
    {
        $this->reset();
        $this->isSubmitted = false;
    }

    public function render()
    {
        // Data dropdown kelas dinamis sesuai jenjang
        $grades = match($this->schoolLevel) {
            'SD' => ['1', '2', '3', '4', '5', '6'],
            'SMP' => ['7', '8', '9'],
            default => []
        };

        return view('livewire.registration-form', [
            'availableGrades' => $grades
        ]);
    }
}
