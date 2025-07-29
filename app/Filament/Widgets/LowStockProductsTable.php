<?php

namespace App\Filament\Widgets;

use App\Models\Product;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Support\Facades\DB;

class LowStockProductsTable extends BaseWidget
{
    protected static ?string $heading = 'Alertas de estoques';
    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Product::query()
                    ->whereColumn('quantity', '<=', DB::raw('min_quantity + 5'))
                    ->orderByRaw('quantity - min_quantity ASC')
                    ->limit(5)
            )
            ->columns([
                Tables\Columns\ImageColumn::make('image')->circular()->label('Imagem'),
                Tables\Columns\TextColumn::make('name')->label('Produto'),
                Tables\Columns\TextColumn::make('quantity')->label('Quantidade em estoque')->sortable(),
                Tables\Columns\TextColumn::make('min_quantity')->label('Quantidade mínima')->sortable(),
            ]);
    }
}
