<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DerivationResource\Pages;
use App\Filament\Resources\DerivationResource\RelationManagers;
use App\Models\Derivation;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Barryvdh\DomPDF\PDF;
use Filament\Forms;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Blade;

class DerivationResource extends Resource
{
    protected static ?string $model = Derivation::class;
    protected static ?string $navigationGroup = 'Usuarios';
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
                            ->label('Usuario')
                            ->relationship('beneficiary', 'name')
                            ->required()
                            ->preload()
                            ->searchable(),
                        Forms\Components\Select::make('volunteer_id')
                            ->label('Voluntario')
                            ->relationship('volunteer', 'name')
                            ->required()
                            ->preload()
                            ->searchable(),
                    ]),
                Fieldset::make('Derivación')
                    ->schema([
                        Forms\Components\Select::make('collaborator_id')
                            ->label('Colaborador')
                            ->relationship('collaborator', 'name')
                            ->required()
                            ->preload()
                            ->searchable()
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('reason')
                            ->label('Motivo')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('observation')
                            ->label('Observaciones')
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
                    ->label('Usuario')
                    ->numeric()
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('volunteer.name')
                    ->label('Voluntario')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('collaborator.name')
                    ->label('Colaborador')
                    ->numeric()
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('reason')
                    ->label('Motivo')
                    ->words(10),
                Tables\Columns\TextColumn::make('observation')
                    ->label('Observaciones')
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
                Tables\Actions\Action::make('pdf') 
                    ->label('PDF')
                    ->color('success')
                    ->icon('tabler-download')
                    ->action(function (Model $record) {
                        return response()->streamDownload(function () use ($record) {
                            echo FacadePdf::loadHtml(
                                Blade::render('pdf.derivation', ['record' => $record])
                            )->stream();
                        },'Derivacion de ' . $record->Beneficiary->name .' a '. $record->Collaborator->name . '.pdf');
                    }), 
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
