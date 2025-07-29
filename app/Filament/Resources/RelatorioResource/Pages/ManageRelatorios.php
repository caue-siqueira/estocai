<?php

namespace App\Filament\Resources\RelatorioResource\Pages;

use App\Filament\Resources\RelatorioResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageRelatorios extends ManageRecords
{
    protected static string $resource = RelatorioResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
