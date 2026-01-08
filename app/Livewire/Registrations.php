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
    public $deleteId = null;
    public $showDeleteModal = false;

    // Reset pagination when filter changes
    public function updatedSearch() { $this->resetPage(); }
    public function updatedJenjang() { $this->resetPage(); }

    public function getStatsProperty()
    {
        return [
            'total_sekolah' => School::count(),
            'total_siswa' => \App\Models\Student::count(),
            'total_sd' => School::where('jenjang_pendidikan', 'SD')->count(),
            'total_smp' => School::where('jenjang_pendidikan', 'SMP')->count(),
        ];
    }

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
            'schools' => $schools,
            'stats' => $this->stats
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

    public function confirmDelete($id)
    {
        $this->deleteId = $id;
        $this->showDeleteModal = true;
    }

    public function cancelDelete()
    {
        $this->deleteId = null;
        $this->showDeleteModal = false;
    }

    public function delete()
    {
        if ($this->deleteId) {
            $school = School::find($this->deleteId);
            if ($school) {
                // Delete associated students first (optional if cascade is set in DB, but good for safety)
                $school->students()->delete();
                $school->delete();
                // Optionally delete operator if not used by other schools, but safe to keep
            }
        }
        $this->showDeleteModal = false;
        $this->deleteId = null;
    }
}
