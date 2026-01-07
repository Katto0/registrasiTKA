<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;

class RegistrationForm extends Component
{
    use WithFileUploads;

    // --- STATE PROPERTIES ---
    public $currentStep = 1;
    public $studentFile;

    // Data Sekolah
    public $npsn = ''; // Trigger utama
    public $schoolName = ''; // Readonly, terisi otomatis
    public $schoolLevel = '';

    // Data Operator
    public $operatorName = '';
    public $phoneNumber = '';
    public $email = '';

    public $isSubmitted = false;

    // --- VALIDATION RULES ---
    protected function rulesStep1()
    {
        return [
            'npsn'         => 'required|numeric|digits:8',
            // School name validasi tetap ada tapi inputnya readonly
            'schoolName'   => 'required|min:3',
            'schoolLevel'  => 'required|in:SD,SMP',
            'operatorName' => ['required', 'min:3', 'regex:/^[a-zA-Z\s\.\,\-\']+$/'],
            'phoneNumber'  => ['required', 'numeric', 'digits_between:10,15', 'starts_with:08'],
            'email'        => 'required|email:dns,rfc|max:255',
        ];
    }

    protected function rulesStep2()
    {
        return [
            'studentFile' => ['required', 'file', 'extensions:xlsx,xls,csv', 'max:10240'],
        ];
    }

    // --- AUTOMATION LOGIC ---

    /**
     * [BACKEND] Fitur Pencarian Sekolah by NPSN
     * Dijalankan otomatis saat user selesai mengetik NPSN (wire:model.blur)
     */
    public function updatedNpsn()
    {
        // 1. Reset Nama Sekolah
        $this->schoolName = '';

        // 2. Validasi format NPSN dulu (harus 8 angka)
        if (strlen($this->npsn) !== 8) {
            return;
        }

        // 3. [SIMULASI] Cari Data Sekolah di Database
        // Backend Developer: Ganti bagian ini dengan query database yang sebenarnya.
        // Contoh: $school = School::where('npsn', $this->npsn)->first();

        // Simulasi data dummy untuk demo:
        $dummyDatabase = [
            '10101010' => 'SD NEGERI 1 CONTOH',
            '20202020' => 'SMP NEGERI 5 JAKARTA',
            '30303030' => 'SD SWASTA HARAPAN BANGSA',
        ];

        if (array_key_exists($this->npsn, $dummyDatabase)) {
            $this->schoolName = $dummyDatabase[$this->npsn];
        } else {
            // Jika tidak ditemukan, bisa dikosongkan atau beri notifikasi error
            $this->addError('npsn', 'Data sekolah tidak ditemukan. Pastikan NPSN benar.');
        }
    }

    public function updatedSchoolLevel()
    {
        // Logic auto-grade dihapus sesuai request sebelumnya
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
        $this->operatorName = ucwords(strtolower(strip_tags(trim($this->operatorName))));
    }

    public function submit()
    {
        $this->sanitizeInput();
        $this->validate($this->rulesStep2());
        $this->validate(array_merge($this->rulesStep1(), $this->rulesStep2()));

        // [BACKEND] Proses simpan data...

        sleep(2);
        $this->isSubmitted = true;
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
