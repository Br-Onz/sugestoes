<div>
    <div class="app-title">
        <div>
            <h1><i class="bi bi-speedometer"></i> Cadastros de Produtos</h1>
            <p>Cadastros de Produtos para o sistema de sugestoes</p>
        </div>
    </div>

    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-lg-10 col-md-12">
                <div class="tile">
                    <h3 class="tile-title text-center mb-4">Formulário de Cadastro</h3>
                    <div class="tile-body">
                        <form wire:submit.prevent="buscar" id="formulario">
                            <div class="row g-3">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md">
                                            <label class="form-label">Código do Produto</label>
                                            <input class="form-control" type="text" placeholder="Digite o código" wire:model="codigo">
                                        </div>
                                        <div class="col-md">
                                            <label class="form-label">Nome do Produto</label>
                                            <input class="form-control" type="text" readonly placeholder="Nome do produto será preenchido" value="{{ $nome }}">
                                        </div>
                                        <div class="col-md">
                                            <label class="form-label">Quantidade</label>
                                            <input class="form-control" type="number" placeholder="Digite a quantidade" wire:model="quantidade">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md">
                                            <label class="form-label">Valor Produto</label>
                                            <input class="form-control" type="text" placeholder="Valor do produto" readonly value="{{ $valor }}" id="valor_produto">
                                        </div>
                                        <div class="col-md">
                                            <label class="form-label">Valor Sugestão</label>
                                            <input class="form-control" type="text" placeholder="Digite o valor sugerido" wire:model="valor_sugestao" id="valor_sugestao" oninput="formatarMoeda(this)">
                                        </div>
                                        <div class="col-md">
                                            <label class="form-label">Data de Vencimento</label>
                                            <input class="form-control" type="date" wire:model="data">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 text-center mt-3">
                                    <input class="btn btn-primary" type="submit" value="Adicionar">
                                </div>
                            </div>
                        </form>

                        <!-- Tabela para visualizar os itens cadastrados -->
                        @if (!empty($itens))
                            <h4 class="mt-5 text-center">Itens Cadastrados</h4>
                            <div style="overflow: auto; height: 300px;">
                                <table class="table table-bordered mt-3">
                                    <thead>
                                    <tr class="text-uppercase text-center">
                                        <th>Código</th>
                                        <th>Nome</th>
                                        <th>Quantidade</th>
                                        <th>Valor</th>
                                        <th>Valor Sugestão</th>
                                        <th>Data de Vencimento</th>
                                        <th>Ações</th> <!-- Nova coluna para ações -->
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($itens as $index => $item)
                                        <tr class="text-uppercase text-center align-middle">
                                            <td>{{ $item['codigo'] }}</td>
                                            <td>{{ $item['nome'] }}</td>
                                            <td>{{ $item['quantidade'] }}</td>
                                            <td>{{ $item['valor'] }}</td>
                                            <td>{{ $item['valor_sugestao'] }}</td>
                                            <td>{{ $item['data'] }}</td>
                                            <td class="flex justify-center gap-3">
                                                <button class="btn btn-primary" wire:click.prevent="editarItem({{ $index }})"><i class="bi bi-pencil"></i></button>
                                                <button class="btn btn-danger" wire:click.prevent="removerItem({{ $index }})"><i class="bi bi-trash"></i></button>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="flex justify-end gap-3 pt-3">
                                <button class="btn btn-success" wire:click.prevent="salvarItens">Salvar Itens</button>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function formatarMoeda(input) {
            // Remove qualquer caractere que não seja um número
            let valor = input.value.replace(/\D/g, '');

            // Formata o valor como moeda brasileira
            valor = (valor / 100).toFixed(2).replace('.', ',');

            // Adiciona o símbolo da moeda
            input.value = valor.replace(/\B(?=(\d{3})+(?!\d))/g, '.') || 'R$ 0,00';
            if (valor) {
                input.value = 'R$ ' + input.value;
            }
        }
    </script>
</div>
