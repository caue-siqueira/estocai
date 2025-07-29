<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StockMovementResource\Widgets\DashboardMovement;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\BadgeColumn;
use App\Filament\Resources\StockMovementResource\Pages;
use App\Filament\Resources\StockMovementResource\RelationManagers;
use App\Models\StockMovement;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Widgets\Dashboard;
use Closure;
use App\Models\Product;


class StockMovementResource extends Resource
{
    protected static ?string $model = StockMovement::class;
    protected static ?string $modelLabel = 'Movimentação';
    protected static ?string $pluralModelLabel = 'Movimentações';
    protected static ?string $navigationIcon = 'heroicon-o-arrows-right-left';

    public static function getNavigationGroup(): ?string
{
    return 'Estoque';
}

public static function getWidgets(): array
    {
        return [
            DashboardMovement::class,
        ];
    }

   public static function form(Form $form): Form
{
    return $form
        ->schema([
            Select::make('product_id')
                ->label('Produto')
                ->relationship('product', 'name')
                ->required(),

            Select::make('type')
                ->label('Tipo')
                ->options([
                    'entrada' => 'Entrada',
                    'saida' => 'Saída',
                ])
                
                ->required(),

            TextInput::make('quantity')
                ->label('Quantidade')
                ->numeric()
                 ->rule(function (callable $get) {
                    return function (string $attribute, $value, Closure $fail) use ($get) {
                    $type = $get('type');
                    $productId = $get('product_id');
                    $product = Product::find($productId);

                    if($type === 'saida' && $product){
                         if ($product->quantity == 0) {
                                $fail("Produdo com estoque vazio.");
                    }
                    }
                    if ($type === 'saida' && $product && $product->quantity < $value) {
                        $fail("Estoque insuficiente. Apenas {$product->quantity} unidade(s) disponível(is).");
                    }
                    
                };
            })


                ->required(),
                
        ]);
}

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('product.name')
                    ->label('Produto')
                    ->searchable(),
                Tables\Columns\BadgeColumn::make('type')
                    ->label('Tipo de Movimento')
                    ->colors([
                        'success' => 'entrada',
                        'danger' => 'saida',
                    ])
                    ->icons([
                        'entrada' => 'lucide-download', 
                        'saida' => 'lucide-upload',    
                    ])
                    ->formatStateUsing(fn (string $state) => ucfirst($state))
                    ->searchable(),
                Tables\Columns\TextColumn::make('quantity')
                    ->label('Quantidade')
                    ->limit(20)
                    ->searchable(),   
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStockMovements::route('/'),
            'create' => Pages\CreateStockMovement::route('/create'),
            'edit' => Pages\EditStockMovement::route('/{record}/edit'),
        ];
    }
}
