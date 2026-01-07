<?php

namespace App\Livewire;

use App\Models\School;
use App\Exports\RegistrationsExport;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

#[Layout('layouts.admin')]
class Registrations extends Component
{
    use WithPagination;

    public $search = '';
    public $jenjang = ''; // Filter by Jenjang
    public $selectedSchool = null;
    public $showDetailModal = false;

    // Reset pagination when filter changes
    public function updatedSearch() { $this->resetPage(); }
    public function updatedJenjang() { $this->resetPage(); }

    public function render()
    {
        $schools = School::with(['operator', 'students'])
            ->when($this->search, function ($query) {
                $query->where('nama_sekolah', 'like', '%' . $this->search . '%')
                      ->orWhere('npsn_sekolah', 'like', '%' . $this->search . '%')
                      ->orWhereHas('operator', function ($q) {
                          $q->where('nama_operator', 'like', '%' . $this->search . '%');
                      });
            })
            ->when($this->jenjang, function ($query) {
                $query->where('jenjang_pendidikan', $this->jenjang);
            })
            ->latest()
            ->paginate(10);

        return view('livewire.registrations', [
            'schools' => $schools
        ]);
    }

    public function export()
    {
        return Excel::download(new RegistrationsExport($this->search, $this->jenjang), 'data-pendaftaran-tka.xlsx');
    }

    public function showDetail($schoolId)
    {
        $this->selectedSchool = School::with(['operator', 'students'])->find($schoolId);
        $this->showDetailModal = true;
    }

    public function closeDetail()
    {
        $this->showDetailModal = false;
        $this->selectedSchool = null;
    }
}
