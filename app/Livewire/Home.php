<?php

namespace App\Livewire;

use App\Models\Pclib;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;


class Home extends Component
{
    use LivewireAlert;

    public $codigo;
    public $nome;
    public $valor;
    public $valor_sugestao;
    public $quantidade;
    public $data;
    public $itens = [];
    public $indexEditando = null;
    public $pclib_fil = [];

    protected $listeners = ['confirmed'];

    public function mount()
    {
        $pclib = Pclib::where('codfunc', auth()->user()->matricula)->
        where('codtabela', 1)->get();
       /* $this->pclib_fil = $pclib;*/
    }

    public function buscar()
    {
        if ($this->codigo) {
            $this->buscarProduto($this->codigo);
        } else {
            $this->toast('error', 'Código do produto não Informado!');
            return;
        }
    }

    public function buscarProduto($codigo)
    {
        $produtos = DB::select(
            "SELECT e.codauxiliar,
                     p.descricao,
                     e.ptabela,
                     e.pvenda,
                     e.codfilial
                  FROM       pcembalagem e
                         INNER JOIN
                             pcprodut p
                         ON e.codprod = p.codprod
                 WHERE   e.codauxiliar = ? and e.codfilial = ?
                 AND NVL (e.pvenda, 0) > 0",
            [$codigo, auth()->user()->codfilial]
        );

        $this->nome = $produtos[0]->descricao;
        $this->valor = 'R$ '.number_format($produtos[0]->pvenda, 2, ',', '.');
        $this->adicionarItem();
    }

    public function adicionarItem()
    {
        $this->validate([
            'codigo' => 'required',
            'nome' => 'required',
            'quantidade' => 'required|numeric',
            'valor' => 'required',
            'valor_sugestao' => 'required',
            'data' => 'required|date',
        ]);

        if (is_null($this->indexEditando)) {
            // Adiciona novo item
            $this->itens[] = [
                'codigo' => $this->codigo,
                'nome' => $this->nome,
                'quantidade' => $this->quantidade,
                'valor' => $this->valor,
                'valor_sugestao' => $this->valor_sugestao,
                'data' => date_format(date_create($this->data), 'd/m/Y'),
            ];
        } else {
            // Edita o item existente
            $this->itens[$this->indexEditando] = [
                'codigo' => $this->codigo,
                'nome' => $this->nome,
                'quantidade' => $this->quantidade,
                'valor' => $this->valor,
                'valor_sugestao' => $this->valor_sugestao,
                'data' => date_format(date_create($this->data), 'd/m/Y'),
            ];
            $this->indexEditando = null;
        }

        // Limpa os campos do formulário
        $this->reset(['codigo', 'nome', 'quantidade', 'valor', 'valor_sugestao', 'data']);
    }

    public function editarItem($index)
    {
        // Carrega os dados do item para edição
        $item = $this->itens[$index];
        $this->codigo = $item['codigo'];
        $this->nome = $item['nome'];
        $this->quantidade = $item['quantidade'];
        $this->valor = $item['valor'];
        $this->valor_sugestao = $item['valor_sugestao'];
        $this->data = date('Y-m-d', strtotime(str_replace('/', '-', $item['data'])));

        $this->indexEditando = $index;
    }

    public function removerItem($index)
    {
        $this->alert('warning', 'Você tem certeza que deseja deletar este item?', [
            'toast' => true,
            'timer' => 50000,
            'position' => 'center',
            'timerProgressBar' => true,
            'showCancelButton' => true,
            'showConfirmButton' => true,
            'onCancel' => 'cancelDeletion',
            'onConfirmed' => 'confirmed',
            'data' => ['index' => $index]
        ]);
    }

    public function confirmed($data)
    {
        $index = $data['index'];
        unset($this->itens[$index]);
        $this->itens = array_values($this->itens);
        $this->toast('success', 'Item deletado com sucesso!');
    }

    public function toast($type, $message)
    {
        $this->alert($type, $message, [
            'timer' => 3000,
            'toast' => true,
            'timerProgressBar' => true,
        ]);
    }

    public function salvarItens()
    {
        foreach ($this->itens as $item) {
            // Corrigindo o valor para garantir que seja um número válido
            $valor_produto = str_replace(['R$ ', '.', ','], ['', '', '.'], $item['valor']);
            $valor_sugestao = str_replace(['R$ ', '.', ','], ['', '', '.'], $item['valor_sugestao']);

            // Certificando-se de que a data é uma string
            $data_vencimento = date('d/m/Y', strtotime($item['data']));

            DB::insert('INSERT INTO bdc_sugestoes@dbl200
                    (id, codauxiliar, descricao, quantidade, valor_produto, valor_sugestao, data_vencimento, status, matricula)
                    VALUES (bdc_sugestoes_seq.NEXTVAL@dbl200, ?, ?, ?, ?, ?, ?, 0, ?)',
                [
                    $item['codigo'],
                    $item['nome'],
                    $item['quantidade'],
                    $valor_produto,
                    $valor_sugestao,
                    $data_vencimento, // Data formatada como string
                    auth()->user()->matricula,
                ]
            );
        }

        $this->toast('success', 'Itens salvos com sucesso!');
        $this->itens = [];
    }


    public function render()
    {
        return view('livewire.home')->layout('layouts.home-layout');
    }
}
