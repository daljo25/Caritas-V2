<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DerivationResource\Pages;
use App\Filament\Resources\DerivationResource\RelationManagers;
use App\Models\Derivation;
use Filament\Forms;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DerivationResource extends Resource
{
    protected static ?string $model = Derivation::class;
    protected static ?string $navigationGroup = 'Beneficiarios';
    protected static ?string $label = 'Derivaciones';
    protected static ?string $navigationIcon = 'tabler-directions';
    protected static ?string $recordTitleAttribute = 'Derivaciones';
    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Fieldset::make('Titular y Voluntario')
                    ->schema([
                        Forms\Components\Select::make('beneficiary_id')
                            ->relationship('beneficiary', 'name')
                            ->required()
                            ->preload()
                            ->searchable(),
                        Forms\Components\Select::make('volunteer_id')
                            ->relationship('volunteer', 'name')
                            ->required()
                            ->preload()
                            ->searchable(),
                    ]),
                Fieldset::make('Derivación')
                    ->schema([
                        Forms\Components\Select::make('collaborator_id')
                            ->relationship('collaborator', 'name')
                            ->required()
                            ->preload()
                            ->searchable()
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('reason')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('observation')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),
                    ]),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('beneficiary.name')
                    ->numeric()
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('volunteer.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('collaborator.name')
                    ->numeric()
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('reason')
                    ->words(10),
                Tables\Columns\TextColumn::make('observation')
                    ->words(10),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => Pages\ListDerivations::route('/'),
            'create' => Pages\CreateDerivation::route('/create'),
            'edit' => Pages\EditDerivation::route('/{record}/edit'),
        ];
    }
}
