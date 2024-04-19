<?php

namespace App\Filament\Resources\BeneficiaryResource\RelationManagers;

use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RecordRelationManager extends RelationManager
{
    protected static string $relationship = 'Record';
    protected static ?string $label = 'Historial';
    protected static ?string $title = 'Historial';

    
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('volunteer_id')
                    ->label('Voluntario')
                    ->required()
                    ->relationship('Volunteer', 'name'),
                Forms\Components\DatePicker::make('date')
                    ->label('Fecha')
                    ->required()
                    ->default(Carbon::now()->format('d-m-Y')),
                Forms\Components\RichEditor::make('incident')
                    ->label('Incidente')
                    ->required()
                    ->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                Tables\Columns\TextColumn::make('Volunteer.name')
                    ->label('Voluntario'),
                Tables\Columns\TextColumn::make('date')
                    ->label('Fecha'),
                Tables\Columns\TextColumn::make('incident')
                    ->label('Incidente')
                    ->words(10)
                    ->wrap()
                    ->html(),
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
