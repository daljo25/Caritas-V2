<?php

namespace App\Filament\Resources\DonorResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DonationRelationManager extends RelationManager
{
    protected static string $relationship = 'Donation';
    protected static ?string $label = 'Donación';
    protected static ?string $pluralLabel = 'Donaciones';
    protected static ?string $title = 'Donaciones';


    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('canal')
                    ->required()
                    ->label('Medio')
                    ->options([
                        'Efectivo' => 'Efectivo',
                        'Transferencia Bancaria' => 'Transferencia Bancaria',
                    ]),
                Forms\Components\DatePicker::make('donation_date')
                    ->required()
                    ->label('Fecha')
                    ->default(now()),
                Forms\Components\TextInput::make('amount')
                    ->required()
                    ->label('Monto')
                    ->inputMode('decimal')
                    ->prefixIcon('heroicon-o-currency-euro')
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                Tables\Columns\TextColumn::make('canal')
                    ->label('Medio'),
                Tables\Columns\TextColumn::make('donation_date')
                    ->label('Fecha')
                    ->date(),
                Tables\Columns\TextColumn::make('amount')
                    ->label('Monto'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
