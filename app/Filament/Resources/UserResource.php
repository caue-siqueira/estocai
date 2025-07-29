<?php

namespace App\Filament\Resources;


use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Database\Eloquent\Model;

class UserResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $modelLabel = 'Usuário';
    protected static ?string $pluralModelLabel = 'Usuários';
    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function getNavigationGroup(): ?string
    {
    return 'Gestão de Usuários';
    }


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Nome')
                    ->required(),
                TextInput::make('email')
                    ->label('Email')
                    ->email()
                    ->required(),
                Select::make('role')
                    ->label('Tipo de Usuário')
                    ->options([
                        'admin' => 'Gestor/Admin',
                        'funcionario' => 'Funcionário',])
                    ->required(),
                TextInput::make('password')
                    ->label('Senha')
                    ->password()
                    ->required(fn(string $context) => $context === 'create')
                    ->minLength(8)
                    ->dehydrateStateUsing(fn ($state) => bcrypt($state))
                    ->dehydrated(fn ($state) => filled($state))
                    ->visible(fn ($livewire) => $livewire instanceof Pages\CreateUser),
                TextInput::make('password_confirmation')
                    ->label('Confirmar Senha')
                    ->password()
                    ->required()
                    ->same('password')
                    ->visible(fn ($livewire) => $livewire instanceof Pages\CreateUser),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                ->label('Nome'),
                Tables\Columns\TextColumn::make('email')
                ->label('Email'),
                Tables\Columns\TextColumn::make('role')
                ->label('Permissão')
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
     public static function canViewAny(): bool
    {
        return auth()->user()->role === 'admin';
    }

    public static function canView(Model $record): bool
    {
        return auth()->user()->role === 'admin';
    }

    public static function canCreate(): bool
    {
        return auth()->user()->role === 'admin';
    }

    public static function canEdit(Model $record): bool
    {
        return auth()->user()->role === 'admin';
    }

    public static function canDelete(Model $record): bool
    {
        return auth()->user()->role === 'admin';
    }



    

}

