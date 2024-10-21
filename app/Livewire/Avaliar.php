<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use PDO;

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
    public $filial;
    public $data_criacao;
    public $dados_cursor = [];

    public $status;
    protected $listeners = ['confirmar'];



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
                                 AND c.codsug = :codsug order by i.codsugitem asc",
                ['codsug' => $index] );
            $this->itensi = $produtos;
            $this->nome = $produtos[0]->nome;
            $this->filial = $produtos[0]->codfilial;

           // dd($produtos[0]->codfilial);
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

    public function StatusItem($CodSugItem,$Codsug,$CodStatus)
    {

        $this->alert('warning', 'Você tem certeza?', [
            'toast' => true,
            'timer' => 50000,
            'position' => 'center',
            'timerProgressBar' => true,
            'showCancelButton' => true,
            'showConfirmButton' => true,
            'onCancel' => 'cancelDeletion',
            'onConfirmed' => 'confirmar',
            'data' => ['CodSugItem' => $CodSugItem,'Codsug' => $Codsug,'CodStatus' => $CodStatus]
        ]);

    }
    public function confirmar($data)
    {

        try {
            if ($data['CodStatus']==1){
                DB::update("UPDATE BDC_SUGESTOESI@DBL200 SET STATUS = 1 WHERE CODSUGITEM = ?", [$data['CodSugItem']]);
            }
            if ($data['CodStatus']==2){
                DB::update("UPDATE BDC_SUGESTOESI@DBL200 SET STATUS = 2 WHERE CODSUGITEM = ?", [$data['CodSugItem']]);
            }
            $this->toast('success', 'Confirmado com Sucesso!');
            $this->modalOpen($data['Codsug']);

        }catch (\Exception $e) {
            $this->toast('error', 'Erro ao Alterar Status!');
        }

    }

    public function getStatusBadge($status)
    {
        $badgeClass = match ($status) {
            '0' => 'badge bg-secondary',
            '1' => 'badge bg-primary',
            '2' => 'badge bg-danger',
            default => 'badge bg-light',
        };

        $statusText = match ($status) {
            '0' => 'AGUARDANDO',
            '1' => 'CONFIRMADO',
            '2' => 'REJEITADO',
            default => 'INDEFINIDO',
        };

        return [
            'class' => $badgeClass,
            'text' => $statusText,
        ];
    }

    public function getStyleTable($status)
    {
        return match ($status) {
            '0' => 'table-warning',
            '1' => 'table-primary',
            '2' => 'table-danger',
            default => '',
        };
    }

    public function buscarProdutoRotina()
    {
        if (!$this->data_final || !$this->data_inicial) {
            $this->toast('error', 'Informe a data inicial e final!');
            return;
        }

        DB::beginTransaction();

        $dt_inicial = \DateTime::createFromFormat('Y-m-d', $this->data_inicial)->format('d/m/Y');
        $dt_final = \DateTime::createFromFormat('Y-m-d', $this->data_final)->format('d/m/Y');

        $dtinicio = $dt_inicial;
        $dtfim =  $dt_final;
        $filialcod = $this->codfilial;
        $prodcod = $this->codprod;

        try {
            $finalResult = [];
            $query = "
                    BEGIN
                        :cursor := bdc_f_sugestoes(
                            :dtinicio,
                            :dtfim,
                            :filialcod,
                            :prodcod
                        );
                    END;
                ";
            $pdo = DB::getPdo();
            $stmt = $pdo->prepare($query);

            $stmt->bindParam(':cursor', $cursor, PDO::PARAM_STMT);
            $stmt->bindParam(':dtinicio', $dtinicio);
            $stmt->bindParam(':dtfim', $dtfim);
            $stmt->bindParam(':filialcod', $filialcod, PDO::PARAM_INT);
            $stmt->bindParam(':prodcod', $prodcod, PDO::PARAM_INT);

            // Executar a consulta
            $stmt->execute();

            // Verificar se o cursor foi retornado
            if ($cursor) {
                // Executar o cursor para obter os resultados
                oci_execute($cursor);

                while ($row = oci_fetch_assoc($cursor)) {
                    $finalResult[] = $row; // Coletar resultados em array
                }
                // Liberar o cursor
                oci_free_statement($cursor);

                // Exibir os resultados para debug
                $this->dados_cursor = $finalResult;

                $this->dispatch('ModalTableAvaliar227');
            } else {
                dd("Nenhum cursor foi retornado.");
            }

            DB::commit();

        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }


    }

    public function index()
    {
        // Defina as variáveis de entrada para a função Oracle
        $dtinicio = '2024-01-01'; // Exemplo de data inicial
        $dtfim = '2024-12-31';    // Exemplo de data final
        $filialcod = '01';        // Código da filial
        $prodcod = '12345';       // Código do produto

        // Chame a função Oracle BDC_F_SUGESTOES com SYS_REFCURSOR
        $sugestoes = DB::select("BEGIN :cursor := BDC_F_SUGESTOES(?, ?, ?, ?); END;", [
            $dtinicio,
            $dtfim,
            $filialcod,
            $prodcod,
        ], [
            'bindings' => [DB::raw(':cursor'), PDO::PARAM_STMT] // Define o cursor como parâmetro de saída
        ]);

        // Exibir o resultado na view
        return view('sugestoes.index', compact('sugestoes'));
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
        return view('livewire.avaliar')->layout('layouts.home-layout');
    }
}
