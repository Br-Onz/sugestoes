<?php

namespace App\Livewire;

use App\Models\Pccontro;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\Pcempr;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Login extends Component
{
    use LivewireAlert;

    public $loginName;
    public $password;

    protected $rules = [
        'loginName' => 'required',
        'password' => 'required',
    ];

    public function login()
    {
        $codrotina = 1444;
        $this->validate(); // Valida o loginName e password

        //Valida Login e retorna Pccontroi para Parametrizar a HOME
        $pcempr = Pcempr::with(['pccontroi' => function ($query) use ($codrotina) {
            $query->where('codrotina', $codrotina);
        }])
            ->where('usuariobd', strtoupper($this->loginName))
            ->whereRaw('decrypt(senhabd,usuariobd) = ?', strtoupper($this->password))
            ->first();


        if (!$pcempr) {
            $this->alert('error', 'Login ou senha inválida', [
                'timer' => 3000,
                'toast' => true,
                'timerProgressBar' => true,
            ]);
            return;
        }

        $pccontro = Pccontro::where('codrotina', $codrotina)
            ->where('acesso', 'S')
            ->where('codusuario', $pcempr->matricula)
            ->first();


        if (!$pccontro) {

            $this->alert('error', 'Usuário sem permissão para acessar o sistema', [
                'timer' => 3000,
                'toast' => true,
                'timerProgressBar' => true,
            ]);
            return;
        }

        if ($pcempr) {

            Auth::login($pcempr);

            return redirect()->route('home');
        }

    }

    public function render()
    {
        return view('livewire.login')->layout('layouts.login-layout');
    }
}
