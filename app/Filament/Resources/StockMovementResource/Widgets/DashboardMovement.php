<?php

namespace App\Filament\Resources\StockMovementResource\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\StockMovement;

class DashboardMovement extends BaseWidget
{
    protected function getStats(): array
    {
        // Gera os últimos 7 dias como rótulos (YYYY-MM-DD)
        $labels = collect(range(0, 6))->map(fn($i) => now()->subDays(6 - $i)->format('Y-m-d'));

        // --- ENTRADAS ---
        $entradas = StockMovement::selectRaw('DATE(created_at) as date, SUM(quantity) as total')
            ->where('type', 'entrada')
            ->whereDate('created_at', '>=', now()->subDays(6))
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->pluck('total', 'date');

        $dadosGraficoEntradas = $labels->map(fn($date) => $entradas[$date] ?? 0)->toArray();
        $totalEntradas = array_sum($dadosGraficoEntradas);
        $mediaEntradas = round($totalEntradas / 7, 2);

        // --- SAÍDAS ---
        $saidas = StockMovement::selectRaw('DATE(created_at) as date, SUM(quantity) as total')
            ->where('type', 'saida')
            ->whereDate('created_at', '>=', now()->subDays(6))
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->pluck('total', 'date');

        $dadosGraficoSaidas = $labels->map(fn($date) => $saidas[$date] ?? 0)->toArray();
        $totalSaidas = array_sum($dadosGraficoSaidas);
        $mediaSaidas = round($totalSaidas / 7, 2);

        return [
            Stat::make('Entradas', $totalEntradas . ' unidades')
                ->description('Últimos 7 dias')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->chart($dadosGraficoEntradas)
                ->color('success'),

            Stat::make('Saídas', $totalSaidas . ' unidades')
                ->description('Últimos 7 dias')
                ->descriptionIcon('heroicon-m-arrow-trending-down')
                ->chart($dadosGraficoSaidas)
                ->color('danger'),

            Stat::make('Média Diária', "↑ {$mediaEntradas} / ↓ {$mediaSaidas}")
                ->description('Entradas e saídas médias por dia')
                ->descriptionIcon('heroicon-m-chart-bar')
                ->color('gray'),
        ];
    }
}
