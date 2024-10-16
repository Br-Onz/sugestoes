<div>
    <div class="app-title">
        <div>
            <h1><i class="bi bi-speedometer"></i> Avaliação de Sugestões</h1>
            <p>Aliviando as sugestões cadastradas</p>
        </div>
    </div>

    <div class="container mt-4" wire:ignore>
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="tile">
                    <h3 class="tile-title">Tabela de Sugestões</h3>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="sampleTable">
                            <thead>
                            <tr class="text-uppercase text-center">
                                <th class="text-center">CODSUG</th>
                                <th class="text-center">NOME</th>
                                <th class="text-center">CODFILIAL</th>
                                <th class="text-center">DATA CRIAÇÃO</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($itensc as $index => $item)
                                <tr class="text-uppercase text-center align-middle cursor-pointer" wire:click="modalOpen({{$item->codsug}})">
                                    <td class="text-center">{{ $item->codsug }}</td>
                                    <td class="text-center">{{ $item->nome }}</td>
                                    <td class="text-center">{{ $item->codfilial }}</td>
                                    <td class="text-center">{{ $item->data }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Itens -->
    <div class="modal fade backdrop-blur-lg" id="ModalTableAvaliar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><i class="bi bi-table"></i> Detalhes da Sugestão</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div>
                        <h6 class="modal-title" id="exampleModalLabel"><i class="bi bi-person-circle"></i> {{ $nome }}</h6>
                        <h6 class="modal-title" id="exampleModalLabel"><i class="bi bi-house-gear-fill"></i> FILIAL: {{ $filial }}</h6>
                        <h6 class="modal-title" id="exampleModalLabel"><i class="bi bi-calendar4-event"></i> {{ $data_criacao }} </h6>
                    </div>
                    <table class="table table-bordered table-hover table-dark mt-3">
                        <thead>
                        <tr class="text-uppercase text-center">
                            <th>CODSUGITEM</th>
                            <th>NOME</th>
                            <th>CODPROD</th>
                            <th>CODAUXILIAR</th>
                            <th>QUANTIDADE</th>
                            <th>DATA VENCIMENTO</th>
                            <th>STATUS</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($itensi as $index => $item)
                            <tr class="text-uppercase text-center align-middle cursor-pointer {{ $item->status == '0' ? 'table-primary' : 'table-danger' }}"
                                wire:click="modalOpenOptions({{$item->codprod}} , {{$item->prod_codauxiliar}}, {{ $item->codfilial }})"
                            >
                                <td>{{ $item->codsugitem }}</td>
                                <td class="truncate" title="{{ $item->descricao }} | {{ $item->unid }}" onmouseover="expandCell(this)" onmouseout="shrinkCell(this)">
                                    <div style="width: 100%; overflow: auto;">
                                        {{ $item->descricao }} | {{ $item->unid }}
                                    </div>
                                </td>
                                <td>{{ $item->codprod }}</td>
                                <td>{{ $item->codauxiliar }}</td>
                                <td>{{ $item->quantidade }}</td>
                                <td>{{ $item->data_vencimento }}</td>
                                <td>
                                    <span class="{{ $item->status == '0' ? 'badge bg-primary' : 'badge bg-danger' }}">
                                       {{ $item->status == '0' ? 'ATIVO' : 'LANÇADO' }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal FILTRO  -->
    <div class="modal fade" id="ModalTableAvaliarOptions" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">FILTRO ROTINA 227</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="buscarProdutoRotina">
                        <div class="row g-3">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md">
                                        <label class="form-label">Codprod</label>
                                        <input type="text" class="form-control" value="{{ $codprod }}" readonly id="codprod" placeholder="Código do produto">
                                    </div>
                                    <div class="col-md">
                                        <label class="form-label">Data inicial</label>
                                        <input type="date" class="form-control" wire:model="data_inicial" id="data_inicial" placeholder="Data inicial">
                                    </div>
                                    <div class="col-md">
                                        <label class="form-label">Data final</label>
                                        <input type="date" class="form-control" wire:model="data_final" id="data_final" placeholder="Data final">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-primary" wire:click="buscarProdutoRotina">Enviar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal 227 -->
    <div class="modal fade" id="ModalTableAvaliar227" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">
                        227 - FICHA TÉCNICA POR FORNECEDOR MASTER
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="col-md-12">
                        <div class="row font-bold mb-2">
                            <div class="col-md-4">
                                <p class="modal-title" id="exampleModalLabel">FORNECEDOR: {{ $dados_cursor[0]['CODFORNEC'] }} - {{ $dados_cursor[0]['FORNECEDOR'] }}</p>
                                <p class="modal-title" id="exampleModalLabel">CONTATO: {{ $dados_cursor[0]['TELFAB'] }}</p>
                            </div>
                            <div class="col-md">
                                <p class="modal-title" id="exampleModalLabel">PRAZO DE ENTREGA: {{ $dados_cursor[0]['PRAZOENTREGA'] }} DIAS</p>
                                <p class="modal-title" id="exampleModalLabel">ULT.RFENTE: {{ $dados_cursor[0]['FRETE'] }} </p>
                            </div>
                            <div class="col-md">
                                <p class="modal-title" id="exampleModalLabel">% DESP FIN: {{ $dados_cursor[0]['PERCDESPFIN'] }}</p>
                                <p class="modal-title" id="exampleModalLabel">PRAZO PAGAMENTO: {{ $dados_cursor[0]['DESCPARCELA'] }}</p>
                            </div>
                            <div class="col-md">
                                <p class="modal-title" id="exampleModalLabel">% DESP FIN: {{ $dados_cursor[0]['PERCDESCFIN'] }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-between gap-3">
                        <table class="table table-bordered table-hover table-dark mt-3">
                            <thead>
                            <tr class="text-uppercase text-center">
                                <th style="width: 23%">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-12 flex gap-3 pb-2" style="font-size: 10px;">
                                                <div>
                                                    <span>COD</span>
                                                </div>
                                                <div class="w-full text-left">
                                                    <span>DESCRIÇÃO</span>
                                                </div>
                                                <div>
                                                    <span>CODFAB</span>
                                                </div>
                                                {{--<span>COD</span>
                                                <span style="width: 300px; text-align: left">DESCRIÇÃO</span>
                                                <span>CODFAB</span>--}}
                                            </div>
                                        </div>
                                    </div>
                                    {{--<div class="flex justify-between  pb-4 gap-3" style="font-size: 13px;">
                                        <span>COD</span>
                                        <span style="width: 300px; text-align: left">DESCRIÇÃO</span>
                                        <span>CODFAB</span>
                                    </div>--}}
                                </th>
                                <th style="width: 15%">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-12 text-center pb-4" style="font-size: 13px;">
                                                <span>ÚLTIMA ENTRADA</span>
                                            </div>
                                            <div class="col-md-12 flex justify-between gap-3" style="font-size: 10px;">
                                                <span>Dt.Ult.Ent</span>
                                                <span>Valor</span>
                                                <span>Qtde</span>
                                            </div>
                                        </div>
                                    </div>
                                </th>
                                <th style="width: 20%">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-12 text-center pb-2" style="font-size: 13px;">
                                                <span>QUANTIDADE VENDA MÊS</span>
                                            </div>
                                            <div class="col-md-12 flex justify-between gap-3" style="font-size: 10px;">
                                                <span>Atual</span>
                                                <span>Ant1</span>
                                                <span>Ant2</span>
                                                <span>Ant3</span>
                                            </div>
                                            <div class="col-md-12 text-center" style="font-size: 10px;">
                                                <span>MÉDIA GIRO</span>
                                            </div>
                                        </div>
                                    </div>
                                </th>
                                <th style="width: 15%">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-12 text-center pb-4" style="font-size: 13px;">
                                                <span>ESTOQUE</span>
                                            </div>
                                            <div class="col-md-12 flex justify-between gap-3" style="font-size: 10px;">
                                                <span>Disp</span>
                                                <span>Fat CD</span>
                                                <span>Ped CD</span>
                                                <span>Dias</span>
                                            </div>
                                        </div>
                                    </div>
                                </th>
                                <th style="width: 15%">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-12 text-center pb-4" style="font-size: 13px;">
                                                <span>MARGEM PREÇO</span>
                                            </div>
                                            <div class="col-md-12 flex justify-between gap-3" style="font-size: 10px;">
                                                <span>P.Venda</span>
                                                <span>Mg-Atual</span>
                                                <span>Mg-Winthor</span>
                                            </div>
                                        </div>
                                    </div>
                                </th>
                                <th>
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-12 text-center pb-4" style="font-size: 13px;">
                                                <span>SUGESTÃO</span>
                                            </div>
                                        </div>
                                    </div>
                                </th>
                                <th>
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-12 text-center pb-4" style="font-size: 13px;">
                                                <span>QT.COMPRA</span>
                                            </div>
                                        </div>
                                    </div>
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($dados_cursor as $index => $item)
                                <td class="text-uppercase text-center">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-12 flex gap-3 pb-2" style="font-size: 10px;">
                                                <div>
                                                    <span>{{ $item['CODPROD'] }}</span>
                                                </div>
                                                <div class="w-full text-left">
                                                    <span>{{ $item['DESCRICAO'].' '.$item['EMBALAGEMMASTER'] }}</span>
                                                </div>
                                                <div>
                                                    <span>{{ $item['CODFAB'] }}</span>
                                                </div>
                                                {{--<span>{{ $item['CODPROD'] }}</span>
                                                <span  style="width: 300px; text-align: left">{{ $item['DESCRICAO'].' '.$item['EMBALAGEMMASTER'] }}</span>
                                                <span>{{ $item['CODFAB'] }}</span>--}}
                                            </div>
                                            <div class="col-md-12 flex justify-between gap-3" style="font-size: 10px;">
                                                <span>{{ $item['CODAUXILIAR'] }}</span>
                                                <span class="text-transparent">{{ $item['DESCRICAO'].' '.$item['EMBALAGEMMASTER'] }}</span>
                                                <span class="text-transparent">{{ $item['CODFAB'] }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-uppercase text-center ">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-12 flex justify-between gap-3 pb-2" style="font-size: 10px;">
                                                <span>{{ date('d/m/Y', strtotime($item['DTULTENT'])) }}</span>
                                                <span>{{ $this->formatMoeda($item['VLULTPCOMPRA']) }}</span>
                                                <span>{{ $item['QTULTENT'] }}</span>
                                            </div>
                                            <div class="col-md-12 flex justify-between gap-3" style="font-size: 10px;">
                                                <span>Unidade ></span>
                                                <span>{{ $this->formatMoeda($item['VALORULTENT']) }}</span>
                                                <span class="text-transparent">{{ $item['QTULTENT'] }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-uppercase text-center">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-12 flex justify-between gap-3 pb-2" style="font-size: 10px;">
                                                <span>{{ $this->formatMoeda($item['QTVENDMES']) }}</span>
                                                <span>{{ $this->formatMoeda($item['QTVENDMES1']) }}</span>
                                                <span>{{ $this->formatMoeda($item['QTVENDMES2']) }}</span>
                                                <span>{{ $this->formatMoeda($item['QTVENDMES3']) }}</span>
                                            </div>
                                            <div class="col-md-12 flex justify-between gap-3" style="font-size: 10px;">
                                                <span>Dia {{ $this->formatMoeda($item['QTGIRODIA']) }}</span>
                                                <span>Sem {{ $this->formatMoeda($item['QTGIROSEMANA']) }}</span>
                                                <span>Mês {{ $this->formatMoeda($item['QTGIROMES']) }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-uppercase text-center">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-12 flex justify-between gap-3" style="font-size: 10px;">
                                                <span>{{ $this->formatMoeda($item['QTESTGER']) }}</span>
                                                <span>Fat CD</span>
                                                <span>Ped CD</span>
                                                <span>{{ $item['ESTDIAS'] }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-12 flex justify-between gap-3" style="font-size: 10px;">
                                                <span>{{ $this->formatMoeda($item['MARGEM_PVENDA']) }}</span>
                                                <span>{{ $this->formatMoeda($item['MARGEM_ATUAL']) }}</span>
                                                <span>{{ $this->formatMoeda($item['MARGEM_WINTHOR']) }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-12 text-center pb-4" style="font-size: 10px;">
                                                <span>{{ $this->formatMoeda($item['SUGCOMPRA']) }}</span>
                                            </div>
                                            <div class="col-md-12 flex justify-between gap-3" style="font-size: 10px;">
                                                <span>Pendente</span>
                                                <span>220</span>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row font-bold">
                                <div class="col-md-12 pb-2 flex gap-5 text-left">
                                    <span>FONECEDOR BLOQUEADO: {{ $dados_cursor[0]['BLOQUEIO'] }}</span>
                                    <span>DATA BLOQUEIO: {{ $dados_cursor[0]['DTBLOQUEIO'] }}</span>
                                </div>
                                <div class="col-md-12 pb-4 gap-5 text-left">
                                    <span>OBSERVACAO: {{ $dados_cursor[0]['OBSERVACAO'] }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Understood</button>
                </div>
            </div>
        </div>
    </div>


</div>
