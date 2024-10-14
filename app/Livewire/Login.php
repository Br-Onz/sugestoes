<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\Pcempr;
use Illuminate\Support\Facades\DB;
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
        $this->validate(); // Valida o loginName e password

        $pcempr = Pcempr::where('nome_guerra', strtoupper($this->loginName))
            ->whereRaw('decrypt(senhabd, usuariobd) = ?', [strtoupper($this->password)])
            ->first();

        dd($pcempr);

        if (!$pcempr) {
            $this->alert('error', 'Login ou senha inválida', [
                'timer' => 3000,
                'toast' => true,
                'timerProgressBar' => true,
            ]);
            return;
        }

        $permiss = DB::select(
            "SELECT cc.codusuario,
                    cc.codrotina,
                    cc.acesso,
                    ii.codcontrole,
                    NVL(TRIM(p.funcao), '') AS funcao,
                    matricula,
                    TRIM(decrypt(p.senhabd, p.usuariobd)) AS senha
             FROM pccontro cc, pcempr p, pccontroi ii
             WHERE cc.codrotina = ?
                AND cc.codusuario = p.matricula
                AND ii.codusuario = p.matricula
                AND ii.codrotina = cc.codrotina
                AND UPPER(TRIM(p.nome_guerra)) = UPPER(?)
                AND UPPER(TRIM(decrypt(p.senhabd, p.usuariobd))) = UPPER(?)",
            [1444, $this->loginName, strtoupper($this->password)]
        );

        if (!$permiss){
            $this->alert('error', 'Usuário sem permissão para acessar o sistema', [
                'timer' => 3000,
                'toast' => true,
                'timerProgressBar' => true,
            ]);
            return;
        }

        if ($pcempr && $permiss) {
            Auth::login($pcempr);
            return redirect()->route('home');
        }
    }

    public function render()
    {
        return view('livewire.login')->layout('layouts.login-layout');
    }
}
