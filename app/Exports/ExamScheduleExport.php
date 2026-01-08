<?php

namespace App\Exports;

use App\Models\ExamSession;
use App\Models\School;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ExamScheduleExport implements FromView, ShouldAutoSize, WithStyles
{
    protected int $schoolId;
    protected string $date;

    public function __construct(int $schoolId, string $date)
    {
        $this->schoolId = $schoolId;
        $this->date = $date;
    }

    public function view(): View
    {
        $school = School::find($this->schoolId);
        $sessions = ExamSession::with(['assignments.student'])
            ->where('school_id', $this->schoolId)
            ->where('exam_date', '>=', $this->date)
            ->orderBy('exam_date')
            ->orderBy('session_number')
            ->get();

        return view('exports.exam-schedule-excel', [
            'school' => $school,
            'sessions' => $sessions,
            'date' => $this->date,
        ]);
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 14]],
            2 => ['font' => ['bold' => true]],
        ];
    }
}
