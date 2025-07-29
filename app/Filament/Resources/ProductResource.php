<?php

namespace App\Filament\Resources;
use App\Models\Category;
use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tab;




class ProductResource extends Resource
{
    protected static ?string $model = Product::class;
    protected static ?string $modelLabel = 'Produto';
    protected static ?string $pluralModelLabel = 'Produtos';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

public static function getNavigationGroup(): ?string
{
    return 'Estoque';
}


   public static function form(Form $form): Form
{
    return $form
        ->schema([
          
            Tabs::make('Produtos')
                ->tabs([
                Tabs\Tab::make('Geral')
                    ->schema([
                        Grid::make(2)->schema([
                            Forms\Components\TextInput::make('name')
                                ->label('Nome')
                                ->required(),
                            Forms\Components\TextInput::make('sku')
                                ->label('SKU')
                                ->unique(ignoreRecord: true)
                                ->required(),
                            Forms\Components\TextArea::make('description')
                                ->label('Descrição')
                           
                                ->columnSpan(2),
                            Forms\Components\Select::make('category_id')
                                ->label('Categoria')
                                ->relationship('category', 'name')
                                ->required(),
                            Forms\Components\Select::make('unit')
                                ->label('Unidade')
                                ->options([
                                    'un' => 'Unidade',
                                    'kg' => 'Quilograma',
                                    'g' => 'Grama',
                                    'l' => 'Litro',
                                    'ml' => 'Mililitro',
                                   
                                ])
                        ]),
                ]),
                Tabs\Tab::make('Estoque')
                    ->schema([
                    Forms\Components\TextInput::make('quantity')
                    ->label('Quantidade atual')
                    ->required(),
                    Forms\Components\TextInput::make('min_quantity')
                    ->label('Quantidade minima')
                    ->numeric()
                    ->default(1)
                    ->required(),
                    Forms\Components\TextInput::make('location')
                    ->label('Localização')
                ]),
                Tabs\Tab::make('Preços')
                    ->schema([
                    Forms\Components\TextInput::make('price')
                    ->label('Preço')
                    ->numeric()
                    ->prefix('R$')
                    
                ]),
                Tabs\Tab::make('Imagem')
                    ->schema([
                    Forms\Components\FileUpload::make('image')
                    ->label('Imagem')
                ]),
                
    ])
    
        ]);
}

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
               Tables\Columns\ImageColumn::make('image')
                    ->circular()
                    ->label('Imagem'),
                    
                Tables\Columns\TextColumn::make('name')
                    ->label('Nome')
                    ->searchable(),
                Tables\Columns\TextColumn::make('price')
                    ->label('Preço')
                    ->money('BRL', true)
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('description')
                    ->label('Descrição')
                    ->limit(20)
                    ->searchable(),   
                Tables\Columns\TextColumn::make('quantity')
                    ->label('Quantidade')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('category.name')
                    ->label('Categoria')
                    ->sortable(),
                
                
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
