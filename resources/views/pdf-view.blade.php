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
    </style>
</head>
<body>

<div class="container">


    <div class="header">

        <div>
            <i class="fa-solid fa-user icon"></i>
            <span>{{$itensc[0]->nome}}</span>
        </div>
        <div>
            <i class="fa-solid fa-building icon"></i>
            <span>{{$itensc[0]->codfilial}}</span>
        </div>
        <div>
            <i class="fa-solid fa-calendar-days icon"></i>
            <span>{{$itensc[0]->data}}</span>
        </div>
    </div>

    <!-- Tabela -->
    <table class="table">
        <thead>
        <tr>
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

        @foreach($itensc['itensi'] as $itensi)
        <tr>

                <td>{{$itensi->codsugitem}}</td>
                <td>{{$itensi->descricao}}</td>
                <td>{{$itensi->codprod}}</td>
                <td>{{$itensi->codauxiliar}}</td>
                <td>{{$itensi->quantidade}}</td>
                <td>{{$itensi->data_vencimento}}</td>
                <td>{{$itensi->status}}</td>

        </tr>
        @endforeach
        </tbody>
    </table>

</div>

</body>
</html>
