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
                            <th>CODFILIAL</th>
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
                                <td>{{ $item->codfilial }}</td>
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
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Understood</button>
                </div>
            </div>
        </div>
    </div>


</div>
