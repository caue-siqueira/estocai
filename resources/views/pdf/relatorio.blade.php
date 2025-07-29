<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            line-height: 1.5;
        }
        h1, h2 {
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            table-layout: fixed;
            word-wrap: break-word;
        }
        th, td {
            border: 1px solid #000;
            padding: 6px;
            font-size: 12px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }
        .section {
            margin-top: 40px;
        }
    </style>
</head>
<body>
    <h1>RELATÓRIO MENSAL</h1>
    <h2>Período: {{ $dataInicio->format('d/m/Y') }} até {{ $dataFim->format('d/m/Y') }}</h2>
    <p><strong>Relatório Gerado em:</strong> {{ now()->format('d/m/Y H:i:s') }}</p>
    <p><strong>Criado por:</strong> {{ $user->name ?? 'Desconhecido' }}</p>
    <hr>
    <p><strong>Valor Total de Produtos:</strong> R$ {{ number_format($valorTotalEstoque, 2, ',', '.') }}</p>
    <p><strong>Valor Total de Entradas:</strong> R$ {{ number_format($valorEntradas, 2, ',', '.') }}</p>
    <p><strong>Valor Total de Saídas:</strong> R$ {{ number_format($valorSaidas, 2, ',', '.') }}</p>

    <div class="section">
        <h3>Movimentações Encontradas</h3>
        @if($movimentos->count())
            <table>
                <thead>
                    <tr>
                        <th>Produto</th>
                        <th>SKU</th>
                        <th>Tipo</th>
                        <th>Categoria</th>
                        <th>Preço</th>
                        <th>Quantidade</th>
                        <th>Data do Movimento</th>
                        <th>Criado em</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($movimentos as $mov)
                        <tr>
                            <td>{{ $mov->product->name }}</td>
                            <td>{{ $mov->product->sku }}</td>
                            <td>{{ $mov->type }}</td>
                            <td>{{ $mov->product->category->name ?? 'Sem categoria' }}</td>
                            <td>R$ {{ number_format($mov->product->price, 2, ',', '.') }}</td>
                            <td>{{ $mov->quantity }}</td>
                            <td>{{ $mov->created_at->format('d/m/Y H:i:s') }}</td>
                            <td>{{ $mov->product->created_at->format('d/m/Y H:i:s') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>Nenhuma movimentação encontrada nesse período.</p>
        @endif
    </div>
        <hr>
    <div class="section">
        <h3>Produtos em Estoque</h3>
        @if($produtosEstoque->count())
            <table>
                <thead>
                    <tr>
                        <th>Produto</th>
                        <th>SKU</th>
                        <th>Categoria</th>
                        <th>Preço</th>
                        <th>Quantidade em Estoque</th>
                        <th>Data de Criação</th>
                        <th>Valor Total em Estoque</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($produtosEstoque as $produto)
                        <tr>
                            <td>{{ $produto->name }}</td>
                            <td>{{ $produto->sku }}</td>
                            <td>{{ $produto->category->name ?? 'Sem categoria' }}</td>
                            <td>R$ {{ number_format($produto->price, 2, ',', '.') }}</td>
                            <td>{{ $produto->quantity }}</td>
                            <td>{{ $produto->created_at->format('d/m/Y H:i:s') }}</td>
                            <td>R$ {{ number_format($produto->price * $produto->quantity, 2, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>Nenhum produto em estoque.</p>
        @endif
    </div>
</body>
</html>
