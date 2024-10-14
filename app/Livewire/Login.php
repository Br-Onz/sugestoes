<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Pcempr;

class Login extends Component
{

    public $loginName;
    public $password;

    protected $rules = [
        'loginName' => 'required',
        'password' => 'required',
    ];

    public function login()
    {
        $this->validate();
        $user = Pcempr::get();
        dd($user);
    }

    public function render()
    {
        return view('livewire.login')->layout('layouts.login-layout');
    }
}
