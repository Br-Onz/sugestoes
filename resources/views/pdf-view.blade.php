<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório de Vendas</title>

    <!-- Adiciona a biblioteca Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-7QHTaHP6uMHm4j8DNKwK3J/AdKuCzZYm9L8uT8qSD5O47hpFGEzYFY7Jp1mR9bbZJ/j+cmLNkAiw0OqrNgfDgg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 20px;
            font-size: 12px;
        }
        .topo-direito {
            position: absolute;
            top: 0;
            right: 0;
            padding: 10px;
            font-size: 14px;
        }
        .conteudo {
            margin-top: 40px; /* Ajuste de margem para não sobrepor o texto do topo */
            text-align: center;
        }
        .container {
            width: 100%;
            margin: auto;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid #000;
        }
        .header div {
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 14px;
        }
        .header .icon {
            font-size: 14px;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        .table th, .table td {
            padding: 2px 4px; /* Reduzido para deixar as linhas mais compactas */
            text-align: center;
            border: 1px solid #000;
            line-height: 1; /* Reduz a altura da linha */
        }
        .table th {
            background-color: #eaeaea;
            font-weight: bold;
        }
        .table td {
            background-color: #f7f7f7;
        }
        .assinatura {
            position: absolute;
            bottom: 50px; /* Ajuste da posição do campo de assinatura */
            left: 50%;
            transform: translateX(-50%);
            text-align: center;
        }
        .linha-assinatura {
            margin-top: 20px;
            width: 300px;
            border-top: 1px solid #000;
        }
    </style>
</head>
<body>
<!-- Texto no topo direito -->
<div class="topo-direito">
    <strong>{{$itensc['pcempr']->usuariobd}} | {{$itensc['pcempr']->matricula}}</strong>
</div>

<!-- Conteúdo do PDF -->
<div class="conteudo">
    <h1>Sugetão Preço</h1>
    <p></p>
</div>
<div class="container">


    <div class="header">

        <div>
            <i class="fa-solid fa-user icon"></i>
            <span>Nome: {{$itensc[0]->nome_guerra}} | {{$itensc[0]->matricula}}</span>
        </div>
        <div>
            <i class="fa-solid fa-building icon"></i>
            <span>Filial: {{$itensc[0]->codfilial}}</span>
        </div>
        <div>
            <i class="fa-solid fa-calendar-days icon"></i>
            <span>Data da Solicitação: {{\Carbon\Carbon::parse($itensc[0]->data)->format('d/m/Y')}}</span>
        </div>
    </div>

    <!-- Tabela -->
    <table class="table">
        <thead>
        <tr>
            <th>CODPROD</th>
            <th>CODAUXILIAR</th>
            <th>NOME</th>
            <th>UNIDADE</th>
            <th>PVENDA</th>
            <th>POFERTA</th>
            <th>VALOR SUGERIDO</th>
            <th>DATA VENCIMENTO</th>
            <th>QUANTIDADE</th>

        </tr>
        </thead>
        <tbody>

        @foreach($itensc['itensi'] as $itensi)
            <tr>

                <td>{{$itensi->codprod}}</td>
                <td>{{$itensi->codauxiliar}}</td>
                <td>{{$itensi->descricao}}</td>
                <td>{{$itensi->unidade}}</td>
                <td>{{$itensi->pvenda}}</td>
                <td>{{$itensi->poferta}}</td>
                <td>{{$itensi->valor_sugerido}}</td>
                <td>{{\Carbon\Carbon::parse($itensi->data_vencimento)->format('d/m/Y') }}</td>
                <td>{{$itensi->quantidade}}</td>

            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="assinatura">
        <div class="linha-assinatura"></div>
        <p>Assinatura</p>
    </div>
</div>

</body>
</html>
