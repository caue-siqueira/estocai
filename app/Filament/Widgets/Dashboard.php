<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class Dashboard extends BaseWidget
{
    protected function getStats(): array
    {
        
        $currentValue = Product::sum(DB::raw('quantity * price'));

        
        $lastMonthValue = Product::whereMonth('created_at', now()->subMonth()->month)
            ->whereYear('created_at', now()->subMonth()->year)
            ->sum(DB::raw('quantity * price'));

        
        $valueDiff = $currentValue - $lastMonthValue;
        $valuePercent = $lastMonthValue > 0 ? ($valueDiff / $lastMonthValue) * 100 : 0;

        $valueDescription = $valuePercent === 0
            ? 'Sem variação desde o mês passado'
            : (abs($valuePercent) < 0.01
                ? 'Variação mínima'
                : number_format(abs($valuePercent), 1, ',', '.') . '% ' . ($valuePercent > 0 ? 'a mais' : 'a menos') . ' que o mês anterior');

        $valueIcon = $valuePercent > 0 ? 'heroicon-m-arrow-trending-up' : ($valuePercent < 0 ? 'heroicon-m-arrow-trending-down' : 'heroicon-m-minus');
        $valueColor = $valuePercent > 0 ? 'success' : ($valuePercent < 0 ? 'danger' : 'danger');

        // Mini gráfico com dois pontos: mês passado e atual
        $valueChart = [$lastMonthValue, $currentValue];

        // Total de produtos atual
        $currentCount = Product::count();

        // Total de produtos cadastrados no mês anterior
        $lastMonthCount = Product::whereMonth('created_at', now()->subMonth()->month)
            ->whereYear('created_at', now()->subMonth()->year)
            ->count();

        $countDiff = $currentCount - $lastMonthCount;
        $countPercent = $lastMonthCount > 0 ? ($countDiff / $lastMonthCount) * 100 : 0;

        $countDescription = $countPercent === 0
            ? 'Sem variação desde o mês passado'
            : (abs($countPercent) < 0.01
                ? 'Variação mínima'
                : number_format(abs($countPercent), 1, ',', '.') . '% ' . ($countPercent > 0 ? 'a mais' : 'a menos') . ' que o mês anterior');

        $countIcon = $countPercent > 0 ? 'heroicon-m-arrow-trending-up' : ($countPercent < 0 ? 'heroicon-m-arrow-trending-down' : 'heroicon-m-minus');
        $countColor = $countPercent > 0 ? 'success' : ($countPercent < 0 ? 'danger' : 'gray');

        $countChart = [$lastMonthCount, $currentCount];

        // Produtos perto ou abaixo do mínimo
        $lowStockCount = Product::whereColumn('quantity', '<', 'minimum_quantity')->count();
        $nearMinimumCount = Product::whereRaw('quantity <= min_quantity + 5')->whereColumn('quantity', '>=', 'min_quantity')->count();

        return [
           Stat::make('Valor Total em Estoque', 'R$ ' . number_format($currentValue, 2, ',', '.'))
                ->description($valueDescription)
                ->descriptionIcon($valueIcon)
                ->chart([$lastMonthValue, $currentValue]) // gráfico com tendência
                ->color($valuePercent > 0 ? 'success' : ($valuePercent < 0 ? 'danger' : 'gray')), // cor com base na variação


            Stat::make('Total de Produtos', $currentCount)
                ->description($countDescription)
                ->descriptionIcon($countIcon)
                ->chart($countChart)
                ->color($countColor),

            Stat::make('Alerta de Estoque', $nearMinimumCount)
                ->description('Produtos abaixo ou perto do mínimo')
                ->descriptionIcon(
                    $lowStockCount > 0
                        ? 'heroicon-m-exclamation-triangle'
                        : 'heroicon-m-check-circle'
                )
                ->color(
                    $lowStockCount > 0
                        ? 'danger'
                        : ($nearMinimumCount > 0 ? 'warning' : 'success')
                ),
        ];
    }
}
