<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;


class PDFController extends Controller
{
    public function gerarPDF() //Fazer Download Direto sem Abrir PDF
    {

        $dados = [
            'titulo' => 'Sugestão',
            'conteudo' => 'Conteúdo do relatório de vendas...',
        ];


        $pdf = Pdf::loadView('pdf-view', $dados);


        return $pdf->download('relatorio.pdf');
    }

    public function visualizarPDF(Request $request)
    {

        $codsug = $request->get('itensc');

        $header = DB::select("SELECT C.CODSUG,
                                           P.NOME,
                                           C.DATA,
                                           C.CODFILIAL
                                    FROM BDC_SUGESTOESC@DBL200 C, PCEMPR P
                                    WHERE C.CODUSUARIO = P.MATRICULA AND C.CODSUG = ?",[$codsug] );


        $itensc=$header;

            $itensi = DB::select("SELECT I.CODSUGITEM, I.CODSUG,i.codauxiliar,
                                           I.DESCRICAO, E.CODPROD,
                                           I.QUANTIDADE, trunc(I.DATA_VENCIMENTO) data_vencimento,
                                           I.STATUS
                                    FROM BDC_SUGESTOESI@DBL200 I, BDC_SUGESTOESC@DBL200 C, PCEMBALAGEM E
                                    WHERE C.CODSUG = I.CODSUG
                                      AND E.CODAUXILIAR = I.CODAUXILIAR
                                      AND C.CODFILIAL = E.CODFILIAL
                                      AND I.CODSUG = ?", [$itensc[0]->codsug]);
        $itensc['itensi'] = $itensi;
        $itensc['pcempr'] = auth()->user();

        dd($itensc);
        $dados = [
            'titulo' => 'Relatório de Vendas',
            'conteudo' => 'Conteúdo do relatório de vendas...',
            'itensc' => $itensc,
        ];

        $pdf = Pdf::loadView('pdf-view', $dados);


        return $pdf->stream('relatorio.pdf');
    }
}
