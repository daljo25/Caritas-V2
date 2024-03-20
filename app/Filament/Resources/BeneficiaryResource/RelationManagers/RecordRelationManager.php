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

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('volunteer_id')
                    ->required()
                    ->relationship('Volunteer', 'name'),
                Forms\Components\DatePicker::make('date')
                    ->required()
                    ->default(Carbon::now()->format('d-m-Y')),
                Forms\Components\RichEditor::make('incident')
                    ->required()
                    ->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                Tables\Columns\TextColumn::make('id'),
                Tables\Columns\TextColumn::make('Volunteer.name'),
                Tables\Columns\TextColumn::make('date'),
                Tables\Columns\TextColumn::make('incident')
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
