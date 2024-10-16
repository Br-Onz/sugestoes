<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Avaliar extends Component
{
    use LivewireAlert;
    public $itensc = [];
    public $itensi = [];
    public $codprod;
    public $codauxiliar_master;
    public $codfilial;
    public $data_inicial;
    public $data_final;
    public $nome;
    public $data_criacao;

    public function mount()
    {
        $itens = DB::select(
            "SELECT  distinct c.codsug,
                             p.nome,
                             TO_CHAR(c.data, 'DD/MM/YYYY HH24:MI:SS') data,
                             c.codfilial
                      FROM   bdc_sugestoesc@dbl200 c,
                             pcempr p
                     WHERE   p.matricula = c.codusuario order by c.codsug desc"
        );
        $this->itensc = $itens;

    }

    public function modalOpen($index)
    {
        try {
            $produtos = DB::select(
                "SELECT   DISTINCT c.codsug,
                                          e.codprod,
                                          TO_CHAR (c.data, 'DD/MM/YYYY HH24:MI:SS') data,
                                          i.codsugitem,
                                          i.codsug,
                                          i.codauxiliar,
                                          i.descricao,
                                          i.valor_produto,
                                          i.valor_sugerido,
                                          TO_CHAR(i.data_vencimento, 'DD/MM/YYYY') data_vencimento,
                                          i.quantidade,
                                          i.status,
                                          i.unid,
                                          c.codfilial,
                                          p.codauxiliar prod_codauxiliar,
                                          emp.nome
                          FROM   bdc_sugestoesi@dbl200 i,
                                 bdc_sugestoesc@dbl200 c,
                                 pcembalagem e,
                                 pcprodut p,
                                 pcempr emp
                         WHERE       i.codsug = c.codsug
                                 AND e.codauxiliar = i.codauxiliar
                                 AND c.codusuario = emp.matricula
                                 AND p.codprod = e.codprod
                                 AND c.codfilial = e.codfilial
                                 AND c.codsug = :codsug",
                ['codsug' => $index] );
            $this->itensi = $produtos;
            $this->nome = $produtos[0]->nome;
            $this->data_criacao = $produtos[0]->data;
            $this->dispatch('ModalTableAvaliar');
        } catch (\Exception $e) {
            $this->toast('error', 'Erro ao buscar produto!');
        }
    }

    public function modalOpenOptions($codigo, $codauxiliar, $codfilial)
    {
        $this->codprod = $codigo;
        $this->codauxiliar_master = $codauxiliar;
        $this->codfilial = $codfilial;
        $this->dispatch('ModalOptions');
    }

    public function buscarProdutoRotina()
    {
        if (!$this->data_final || !$this->data_inicial) {
            $this->toast('error', 'Informe a data inicial e final!');
            return;
        }

        $this->dispatch('ModalTableAvaliar227');

    }

    public function toast($type, $message)
    {
        $this->alert($type, $message, [
            'timer' => 3000,
            'toast' => true,
            'timerProgressBar' => true,
        ]);
    }

    public function render()
    {
        return view('livewire.avaliar')->layout('layouts.home-layout');
    }
}
