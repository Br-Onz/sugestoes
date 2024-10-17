<?php

namespace App\Livewire;

use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\WithPagination;

class Solicitados extends Component
{
    use LivewireAlert, WithPagination;
    public $itensc = [];
    public $itensi = [];
    public $codsug;
    public $codsugitem;
    public $quantidade;
    public $data_vencimento;
    public $valor_sugerido;
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
                     WHERE   p.matricula = c.codusuario and c.codusuario = :codusuario order by c.codsug desc ", ['codusuario' => auth()->user()->matricula]
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
                                 AND c.codsug = :codsug order by i.codsugitem", ['codsug' => $index]
            );
            $this->itensi = $produtos;
            $this->nome = $produtos[0]->nome;
            $this->data_criacao = $produtos[0]->data;
            $this->dispatch('ModalTableAvaliar');
        } catch (\Exception $e) {
            $this->toast('error', 'Erro ao buscar produto!');
        }
    }

    public function editItem($codsug, $codsugitem, $quantidade, $valor_sugerido, $data_vencimento)
    {
        $this->codsug = $codsug;
        $this->codsugitem = $codsugitem;
        $this->quantidade = $quantidade;
        $this->valor_sugerido = $this->formatMoeda($valor_sugerido);

        $data_convertida = \DateTime::createFromFormat('d/m/Y', $data_vencimento);
        $this->data_vencimento = $data_convertida ? $data_convertida->format('Y-m-d') : null;

        $this->dispatch('ModalEditItem');
    }

    public function updateItem()
    {
        try {
            $data_convertida = \DateTime::createFromFormat('Y-m-d', $this->data_vencimento);
            $data_vencimento = $data_convertida ? $data_convertida->format('d/m/Y') : null;
            $valor_sugerido = str_replace(['R$ ', '.', ','], ['', '', '.'], $this->valor_sugerido);

            DB::update(
                "UPDATE bdc_sugestoesi@dbl200
                    SET quantidade = :quantidade,
                        valor_sugerido = :valor_sugerido,
                        data_vencimento = TO_DATE(:data_vencimento, 'DD/MM/YYYY')
                  WHERE codsug = :codsug
                    AND codsugitem = :codsugitem",
                [
                    'quantidade' => $this->quantidade,
                    'valor_sugerido' => $valor_sugerido,
                    'data_vencimento' => $data_vencimento,
                    'codsug' => $this->codsug,
                    'codsugitem' => $this->codsugitem
                ]
            );

            $this->modalOpen($this->codsug);
            $this->toast('success', 'Item atualizado com sucesso!');
            $this->dispatch('closeModalEditItem');
        } catch (\Exception $e) {
            $this->toast('error', 'Erro ao atualizar item!');
        }
    }

    public function toast($type, $message)
    {
        $this->alert($type, $message, [
            'timer' => 3000,
            'toast' => true,
            'timerProgressBar' => true,
        ]);
    }

    public function formatMoeda($value)
    {
        return 'R$ ' . number_format($value, 2, ',', '.');
    }

    public function render()
    {
        return view('livewire.solicitados')->layout('layouts.home-layout');
    }
}