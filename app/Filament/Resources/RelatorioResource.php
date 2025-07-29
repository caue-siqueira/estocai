<?php

namespace App\Filament\Resources;


use App\Filament\Resources\RelatorioResource\Pages;
use App\Filament\Resources\RelatorioResource\RelationManagers;
use App\Models\Relatorio;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\Action;
use Filament\Http\Controller\DownloadPdfController;

use Filament\Tables\Columns\Actions;

use App\Models\Movimentacao;

use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;

class RelatorioResource extends Resource
{
    protected static ?string $model = Relatorio::class;

    protected static ?string $modelLabel = 'Relatório';
    protected static ?string $pluralModelLabel = 'Relatórios';
    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';

    public static function getNavigationGroup(): ?string
{
    return 'Estoque';
}



    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\DatePicker::make('data_inicial')
                    ->default(Carbon::now()->startOfMonth())
                    ->required(),
                Forms\Components\DatePicker::make('data_final')
                    ->default(Carbon::now()->endOfMonth())
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nome')
                    ->searchable(),
                Tables\Columns\TextColumn::make('data_inicial')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('data_final')
                    ->date()
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Criado em')
                    ->formatStateUsing(fn ($state) => \Carbon\Carbon::parse($state)->format('d/m/Y H:i'))
                    ->sortable()
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\DeleteAction::make(),
                Action::make('Download')
                ->url(fn(Relatorio $record) => route('relatorio.pdf.download', $record))
                ->openUrlInNewTab(),
                

            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageRelatorios::route('/'),
        ];
    }
}
