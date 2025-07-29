<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Relatorio;
use App\Models\StockMovement;
use Carbon\Carbon;
use App\Models\Product;
use App\Services\PdfReportService;

class DownloadPdfController extends Controller
{
    public function download(Relatorio $record, PdfReportService $pdfReportService)
    {
        $dataInicio = Carbon::parse($record->data_inicial)->startOfDay();
        $dataFim = Carbon::parse($record->data_final)->endOfDay();

        $user = auth()->user();

        // Movimentos no período
        $movimentos = StockMovement::with(['product.category'])
            ->whereBetween('created_at', [$dataInicio, $dataFim])
            ->get();

        // Totais com base em movimentações
        $valorTotalProdutos = $movimentos->sum(fn($m) => $m->product->price * $m->quantity);
        $valorEntradas = $movimentos->where('type', 'entrada')->sum(fn($m) => $m->product->price * $m->quantity);
        $valorSaidas = $movimentos->where('type', 'saida')->sum(fn($m) => $m->product->price * $m->quantity);

        // Estoque atual — apenas produtos criados até a data final do relatório
        $produtosEstoque = Product::with('category')
            ->where('quantity', '>', 0)
            ->where('created_at', '<=', $dataFim)
            ->get();

        // Valor total do estoque atual (filtrado por data de criação)
        $valorTotalEstoque = $produtosEstoque->sum(fn($produto) => $produto->price * $produto->quantity);

        // Geração do PDF
        return $pdfReportService->gerar([
            'dataInicio' => $dataInicio,
            'dataFim' => $dataFim,
            'user' => $user,
            'movimentos' => $movimentos,
            'produtosEstoque' => $produtosEstoque,
            'valorTotalProdutos' => $valorTotalProdutos,
            'valorEntradas' => $valorEntradas,
            'valorSaidas' => $valorSaidas,
            'valorTotalEstoque' => $valorTotalEstoque,
        ]);
    }
}
