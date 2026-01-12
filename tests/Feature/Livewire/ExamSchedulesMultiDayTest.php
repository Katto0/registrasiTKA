<?php

namespace Tests\Feature\Livewire;

use App\Livewire\ExamSchedules;
use App\Models\ExamSession;
use App\Models\School;
use App\Models\Student;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class ExamSchedulesMultiDayTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_generate_multi_day_schedule()
    {
        // 10 devices -> 30 students per day (3 sessions)
        // We want 50 students total -> Should take 2 days
        // Day 1: 30 students (Session 1, 2, 3)
        // Day 2: 20 students (Session 1, 2)
        
        $devices = 10;
        $totalStudents = 50;
        
        $school = School::factory()->create(['jumlah_perangkat' => $devices]);
        Student::factory()->count($totalStudents)->create(['school_id' => $school->id]);

        $startDate = '2026-01-12'; // Monday

        Livewire::test(ExamSchedules::class)
            ->set('selectedSchoolIds', [$school->id])
            ->set('startDate', $startDate)
            ->call('generate');

        // Check Day 1
        $day1Sessions = ExamSession::where('school_id', $school->id)
            ->where('exam_date', $startDate)
            ->get();
        
        $this->assertCount(3, $day1Sessions); // Should have 3 sessions
        
        // Check Day 2
        $nextDate = \Carbon\Carbon::parse($startDate)->addDay()->toDateString();
        $day2Sessions = ExamSession::where('school_id', $school->id)
            ->where('exam_date', $nextDate)
            ->get();
            
        $this->assertCount(2, $day2Sessions); // Should have 2 sessions (remaining 20 students / 10 devices = 2 sessions)

        // Verify total assignments
        $totalAssignments = 0;
        foreach ($day1Sessions as $s) {
            $totalAssignments += $s->assignments()->count();
        }
        foreach ($day2Sessions as $s) {
            $totalAssignments += $s->assignments()->count();
        }
        
        $this->assertEquals($totalStudents, $totalAssignments);
    }
}
