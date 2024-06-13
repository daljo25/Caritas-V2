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
                Forms\Components\Select::make('source')
                    ->required()
                    ->label('Medio')
                    ->options([
                        'Efectivo' => 'Efectivo',
                        'Transferencia Bancaria' => 'Transferencia Bancaria',
                    ]),
                Forms\Components\Select::make('donation_month')
                    ->required()
                    ->label('Mes')
                    ->options([
                        '01' => 'Enero',
                        '02' => 'Febrero',
                        '03' => 'Marzo',
                        '04' => 'Abril',
                        '05' => 'Mayo',
                        '06' => 'Junio',
                        '07' => 'Julio',
                        '08' => 'Agosto',
                        '09' => 'Septiembre',
                        '10' => 'Octubre',
                        '11' => 'Noviembre',
                        '12' => 'Diciembre'
                    ]),
                    Forms\Components\Select::make('donation_year')
                    ->required()
                    ->label('Año')
                    ->options([
                        '2024' => '2024',
                        '2025' => '2025',
                        '2026' => '2026',
                        '2027' => '2027',
                        '2028' => '2028',
                        '2029' => '2029',
                        '2030' => '2030',
                    ]),
                Forms\Components\TextInput::make('amount')
                    ->required()
                    ->label('Cantidad')
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
                Tables\Columns\TextColumn::make('source')
                    ->label('Medio')
                    ->sortable(),
                Tables\Columns\TextColumn::make('donation_month')
                    ->label('Mes')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('donation_year')
                    ->label('Año')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('amount')
                    ->label('Cantidad'),
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
