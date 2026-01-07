<?php

namespace App\Livewire;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class Registrations extends Component
{
    public function render()
    {
        return view('livewire.registrations');
    }
}
