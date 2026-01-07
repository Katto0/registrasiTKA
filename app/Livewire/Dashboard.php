<?php

namespace App\Livewire;

use App\Models\Operator;
use App\Models\School;
use App\Models\Student;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin')]
class Dashboard extends Component
{
    public function render()
    {
        return view('livewire.dashboard', [
            'totalSchools' => School::count(),
            'totalStudents' => Student::count(),
            'totalOperators' => Operator::count(),
            'recentSchools' => School::with('operator')->latest()->take(5)->get(),
        ]);
    }
}
