<?php

namespace Tests\Feature\Livewire;

use App\Livewire\ExamSchedules;
use App\Models\ExamSession;
use App\Models\School;
use App\Models\Student;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ExamSchedulesTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function can_generate_three_sessions_and_assign_students_for_one_school(): void
    {
        $school = School::factory()->create([
            'jumlah_perangkat' => 10,
        ]);

        Student::factory()->count(30)->create([
            'school_id' => $school->id,
        ]);

        Livewire::test(ExamSchedules::class)
            ->set('startDate', '2026-01-10')
            ->set('selectedSchoolIds', [$school->id])
            ->call('generate')
            ->assertSet('results.0.status', 'ok');

        $this->assertDatabaseCount('exam_sessions', 3);

        $sessions = ExamSession::query()
            ->where('school_id', $school->id)
            ->where('exam_date', '2026-01-10')
            ->orderBy('session_number')
            ->get();

        $this->assertCount(3, $sessions);
        $this->assertSame('07:30:00', $sessions[0]->start_time);
        $this->assertSame('09:40:00', $sessions[0]->end_time);
        $this->assertSame('10:10:00', $sessions[1]->start_time);
        $this->assertSame('12:20:00', $sessions[1]->end_time);
        $this->assertSame('13:30:00', $sessions[2]->start_time);
        $this->assertSame('15:40:00', $sessions[2]->end_time);

        $this->assertDatabaseCount('exam_assignments', 30);
    }

    #[Test]
    public function can_generate_multi_day_schedule_when_capacity_exceeded(): void
    {
        $school = School::factory()->create([
            'jumlah_perangkat' => 5, // 15 students per day (3 sessions * 5)
        ]);

        Student::factory()->count(16)->create([
            'school_id' => $school->id,
        ]);

        // 16 students > 15 capacity -> should spill over to next day
        Livewire::test(ExamSchedules::class)
            ->set('startDate', '2026-01-10')
            ->set('selectedSchoolIds', [$school->id])
            ->call('generate')
            ->assertSet('results.0.status', 'ok');

        // Day 1: 3 sessions (15 students)
        // Day 2: 1 session (1 student)
        $this->assertDatabaseCount('exam_sessions', 4);
        $this->assertDatabaseCount('exam_assignments', 16);
    }

    #[Test]
    public function does_not_mix_students_between_schools(): void
    {
        $schoolA = School::factory()->create(['jumlah_perangkat' => 5]);
        $schoolB = School::factory()->create(['jumlah_perangkat' => 5]);

        Student::factory()->count(10)->create(['school_id' => $schoolA->id]);
        Student::factory()->count(10)->create(['school_id' => $schoolB->id]);

        Livewire::test(ExamSchedules::class)
            ->set('startDate', '2026-01-10')
            ->set('selectedSchoolIds', [$schoolA->id, $schoolB->id])
            ->call('generate');

        $mismatchCount = DB::table('exam_assignments as ea')
            ->join('exam_sessions as es', 'es.id', '=', 'ea.exam_session_id')
            ->join('students as s', 's.id', '=', 'ea.student_id')
            ->whereColumn('es.school_id', '!=', 's.school_id')
            ->count();

        $this->assertSame(0, $mismatchCount);
    }
}
