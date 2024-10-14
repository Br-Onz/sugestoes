<?php

namespace App\Livewire;

use Livewire\Component;

class Home extends Component
{
    public $name = 'John Doe';

    public function render()
    {
        return view('livewire.home')->layout('layouts.home-layout');
    }
}
