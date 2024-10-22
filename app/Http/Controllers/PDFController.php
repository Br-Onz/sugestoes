<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Crypt;
use Jantinnerezo\LivewireAlert\LivewireAlert;


class PDFController extends Controller
{

    use LivewireAlert;

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

        $codsug = Crypt::decrypt($request->input('itensc'));

        $header = DB::select("SELECT *
                                    FROM BDC_SUGESTOESC@DBL200 C, PCEMPR P
                                    WHERE C.CODUSUARIO = P.MATRICULA AND C.CODSUG = ?",[$codsug] );


        $itensc=$header;

        $itensi = DB::select("SELECT *
                                    FROM BDC_SUGESTOESI@DBL200 I, BDC_SUGESTOESC@DBL200 C, PCEMBALAGEM E
                                    WHERE C.CODSUG = I.CODSUG
                                      AND E.CODAUXILIAR = I.CODAUXILIAR
                                      AND C.CODFILIAL = E.CODFILIAL
                                      AND I.STATUS=1
                                      AND I.CODSUG = ?", [$itensc[0]->codsug]);
        if(empty($itensi)){
            return redirect()->route('avaliar');
        }
        $itensc['itensi'] = $itensi;
        $itensc['pcempr'] = auth()->user();


        $dados = [
            'titulo' => 'Relatório de Vendas',
            'conteudo' => 'Conteúdo do relatório de vendas...',
            'itensc' => $itensc,
        ];

        $pdf = Pdf::loadView('pdf-view', $dados)->setPaper('a4', 'landscape');


        return $pdf->stream('relatorio.pdf');
    }


    public function toast($type, $message)
    {
        $this->alert($type, $message, [
            'timer' => 3000,
            'toast' => true,
            'timerProgressBar' => true,
        ]);
    }

}
