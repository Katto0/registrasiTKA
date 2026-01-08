<?php

namespace Tests\Feature\Livewire;

use App\Livewire\ExamSchedules;
use App\Models\ExamAssignment;
use App\Models\ExamSession;
use App\Models\School;
use App\Models\Student;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Maatwebsite\Excel\Facades\Excel;
use Tests\TestCase;

class ExamSchedulesExportTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_download_excel_export()
    {
        Excel::fake();

        $school = School::factory()->create();
        $date = now()->toDateString();
        
        $session = ExamSession::create([
            'school_id' => $school->id,
            'exam_date' => $date,
            'session_number' => 1,
            'start_time' => '07:30:00',
            'end_time' => '09:40:00',
            'capacity' => 20,
        ]);

        Livewire::test(ExamSchedules::class)
            ->set('startDate', $date)
            ->call('exportExcel', $school->id);

        Excel::assertDownloaded('jadwal-ujian-' . $school->id . '-' . $date . '.xlsx');
    }

    public function test_can_download_pdf_export()
    {
        $school = School::factory()->create();
        $date = now()->toDateString();
        
        $session = ExamSession::create([
            'school_id' => $school->id,
            'exam_date' => $date,
            'session_number' => 1,
            'start_time' => '07:30:00',
            'end_time' => '09:40:00',
            'capacity' => 20,
        ]);

        Livewire::test(ExamSchedules::class)
            ->set('startDate', $date)
            ->call('exportPdf', $school->id)
            ->assertStatus(200); // It returns a stream download response
    }

    public function test_can_view_session_details()
    {
        $school = School::factory()->create();
        $student = Student::factory()->create(['school_id' => $school->id]);
        $date = now()->toDateString();
        
        $session = ExamSession::create([
            'school_id' => $school->id,
            'exam_date' => $date,
            'session_number' => 1,
            'start_time' => '07:30:00',
            'end_time' => '09:40:00',
            'capacity' => 20,
        ]);

        ExamAssignment::create([
            'exam_session_id' => $session->id,
            'student_id' => $student->id,
            'seat_number' => 1,
        ]);

        Livewire::test(ExamSchedules::class)
            ->call('showSessionDetails', $session->id)
            ->assertSet('showDetailModal', true)
            ->assertSet('selectedSession.id', $session->id)
            ->assertSee($student->nama_siswa);
    }
}
