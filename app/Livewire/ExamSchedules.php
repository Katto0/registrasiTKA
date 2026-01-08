<?php

namespace App\Livewire;

use App\Exports\ExamScheduleExport;
use App\Models\ExamSession;
use App\Models\School;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

#[Layout('layouts.admin')]
class ExamSchedules extends Component
{
    use WithPagination;

    public string $search = '';
    public array $selectedSchoolIds = [];
    public string $startDate = '';
    public array $results = [];
    
    // Detailed View Properties
    public $selectedSession = null;
    public bool $showDetailModal = false;

    public function mount()
    {
        $this->startDate = now()->toDateString();
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    private function sessionDefinitions(): array
    {
        return [
            1 => ['start' => '07:30:00', 'end' => '09:40:00'],
            2 => ['start' => '10:10:00', 'end' => '12:20:00'],
            3 => ['start' => '13:30:00', 'end' => '15:40:00'],
        ];
    }

    public function toggleSchool(int $schoolId)
    {
        if (in_array($schoolId, $this->selectedSchoolIds, true)) {
            $this->selectedSchoolIds = array_values(array_filter(
                $this->selectedSchoolIds,
                fn ($id) => (int) $id !== $schoolId
            ));
            return;
        }

        $this->selectedSchoolIds[] = $schoolId;
        $this->selectedSchoolIds = array_values(array_unique(array_map('intval', $this->selectedSchoolIds)));
    }

    public function selectAllVisible()
    {
        $ids = School::query()
            ->when($this->search, function ($q) {
                $q->where('nama_sekolah', 'like', '%' . $this->search . '%')
                    ->orWhere('npsn_sekolah', 'like', '%' . $this->search . '%');
            })
            ->pluck('id')
            ->map(fn ($v) => (int) $v)
            ->toArray();

        $this->selectedSchoolIds = $ids;
    }

    public function clearSelection()
    {
        $this->selectedSchoolIds = [];
    }

    public function generate()
    {
        $this->validate([
            'startDate' => ['required', 'date'],
            'selectedSchoolIds' => ['array', 'min:1'],
        ]);

        $this->results = [];

        $schools = School::with(['students:id,school_id', 'operator:id,nama_operator'])
            ->withCount('students')
            ->whereIn('id', $this->selectedSchoolIds)
            ->get()
            ->keyBy('id');

        foreach ($this->selectedSchoolIds as $schoolId) {
            $school = $schools->get((int) $schoolId);
            if (!$school) {
                $this->results[] = [
                    'school_id' => (int) $schoolId,
                    'status' => 'error',
                    'message' => 'Sekolah tidak ditemukan.',
                ];
                continue;
            }

            $devices = (int) $school->jumlah_perangkat;
            $studentsCount = (int) $school->students_count;

            if ($devices <= 0) {
                $this->results[] = [
                    'school_id' => (int) $school->id,
                    'status' => 'error',
                    'message' => 'Jumlah perangkat harus lebih dari 0.',
                ];
                continue;
            }

            if ($studentsCount <= 0) {
                $this->results[] = [
                    'school_id' => (int) $school->id,
                    'status' => 'error',
                    'message' => 'Sekolah ini belum memiliki data siswa.',
                ];
                continue;
            }

            DB::transaction(function () use ($school, $devices, $studentsCount) {
                // Delete ALL existing sessions for this school to avoid conflicts/duplicates
                // Since we are regenerating the full schedule.
                $existingSessionIds = ExamSession::query()
                    ->where('school_id', $school->id)
                    ->pluck('id');
                
                if ($existingSessionIds->isNotEmpty()) {
                    ExamSession::whereIn('id', $existingSessionIds)->delete();
                }

                $definitions = $this->sessionDefinitions();
                $students = $school->students()->select('id', 'school_id')->inRandomOrder()->get();
                
                // Chunk students by device capacity
                $chunks = $students->chunk($devices);
                
                $generatedSessions = 0;
                $daysUsed = [];

                foreach ($chunks as $index => $chunkStudents) {
                    // Calculate Day and Session Number
                    // Index 0, 1, 2 -> Day 0
                    // Index 3, 4, 5 -> Day 1
                    $dayOffset = floor($index / 3);
                    $sessionNumber = ($index % 3) + 1;
                    
                    $currentDate = \Carbon\Carbon::parse($this->startDate)->addDays($dayOffset)->toDateString();
                    $daysUsed[$currentDate] = true;

                    $time = $definitions[$sessionNumber];

                    $session = ExamSession::create([
                        'school_id' => $school->id,
                        'exam_date' => $currentDate,
                        'session_number' => $sessionNumber,
                        'start_time' => $time['start'],
                        'end_time' => $time['end'],
                        'capacity' => $devices,
                    ]);

                    $rows = [];
                    $seat = 1;
                    foreach ($chunkStudents as $student) {
                        $rows[] = [
                            'exam_session_id' => $session->id,
                            'student_id' => $student->id,
                            'seat_number' => $seat++,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ];
                    }
                    
                    if (!empty($rows)) {
                        $session->assignments()->insert($rows);
                    }
                    $generatedSessions++;
                }

                $totalDays = count($daysUsed);
                $endDate = array_key_last($daysUsed);

                $this->results[] = [
                    'school_id' => (int) $school->id,
                    'status' => 'ok',
                    'message' => "Berhasil generate jadwal. Total siswa: $studentsCount. Terbagi menjadi $generatedSessions sesi dalam $totalDays hari (Mulai: {$this->startDate}).",
                ];
            });
        }
    }

    public function exportExcel($schoolId)
    {
        return Excel::download(new ExamScheduleExport($schoolId, $this->startDate), 'jadwal-ujian-' . $schoolId . '-' . $this->startDate . '.xlsx');
    }

    public function exportPdf($schoolId)
    {
        $school = School::find($schoolId);
        // Export ALL sessions for this school from the start date onwards
        $sessions = ExamSession::with(['assignments.student'])
            ->where('school_id', $schoolId)
            ->where('exam_date', '>=', $this->startDate)
            ->orderBy('exam_date')
            ->orderBy('session_number')
            ->get();

        $pdf = Pdf::loadView('exports.exam-schedule-pdf', [
            'school' => $school,
            'sessions' => $sessions,
            'date' => $this->startDate,
        ]);

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, 'jadwal-ujian-' . $schoolId . '-' . $this->startDate . '.pdf');
    }

    public function showSessionDetails($sessionId)
    {
        $this->selectedSession = ExamSession::with(['assignments.student', 'school'])
            ->findOrFail($sessionId);
        $this->showDetailModal = true;
    }

    public function closeSessionDetails()
    {
        $this->showDetailModal = false;
        $this->selectedSession = null;
    }

    public function render()
    {
        $schools = School::query()
            ->with(['operator:id,nama_operator'])
            ->withCount('students')
            ->when($this->search, function ($q) {
                $q->where('nama_sekolah', 'like', '%' . $this->search . '%')
                    ->orWhere('npsn_sekolah', 'like', '%' . $this->search . '%');
            })
            ->orderBy('nama_sekolah')
            ->paginate(15);

        $sessions = ExamSession::query()
            ->withCount('assignments')
            ->where('exam_date', '>=', $this->startDate ?: now()->toDateString())
            ->whereIn('school_id', $this->selectedSchoolIds ?: [0])
            ->orderBy('school_id')
            ->orderBy('exam_date')
            ->orderBy('session_number')
            ->get();

        return view('livewire.exam-schedules', [
            'schools' => $schools,
            'sessions' => $sessions,
            'sessionDefinitions' => $this->sessionDefinitions(),
        ]);
    }
}
