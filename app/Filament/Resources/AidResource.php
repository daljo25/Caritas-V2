<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AidResource\Pages;
use App\Filament\Resources\AidResource\RelationManagers;
use App\Models;
use App\Models\Aid;
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
use Illuminate\Database\Eloquent\Model as Model2;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Blade;

class AidResource extends Resource
{
    protected static ?string $model = Aid::class;
    protected static ?string $navigationGroup = 'Usuarios';
    protected static ?string $navigationLabel = 'Ayudas';
    protected static ?string $navigationIcon = 'tabler-coin-euro';
    protected static ?string $recordTitleAttribute = 'Ayudas';
    protected static ?string $label = 'Ayudas';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Fieldset::make('Titular y Voluntario')
                    ->schema([
                        Forms\Components\Select::make('beneficiary_id')
                            ->relationship('beneficiary', 'name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->label('Usuario'),
                        Forms\Components\Select::make('volunteer_id')
                            ->relationship('volunteer', 'name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->label('Voluntario'),
                    ]),
                Fieldset::make('Ayuda')
                    ->schema([
                        Forms\Components\Select::make('type')
                            ->label('Tipo de Ayuda')
                            ->required()
                            ->options([
                                'Lucha Contra la Pobresa Energetica' => [
                                    'Pago de suministro' => 'Pago de suministro',
                                    'Mejora de aislamiento' => 'Mejora de aislamiento',
                                    'Adquision y reposicion de elementos luminosos de bajo consumo' => 'Adquision y reposicion de elementos luminosos de bajo consumo',
                                    'Adecuacion, mejora, reparacion y/o mantenimiento de instalaciones y equipamoientos' => 'Adecuacion, mejora, reparacion y/o mantenimiento de instalaciones y equipamoientos',
                                    'Otras nececidades basicas de energia' => 'Otras nececidades basicas de energia',
                                ],
                                'Gastos Relativos a la Vivienda' => [
                                    'Impago de alquiler' => 'Impago de alquiler',
                                    'Impago de credito hipotecario' => 'Impago de credito hipotecario',
                                    'Gastos derivados de las alternativas al alquiler' => 'Gastos derivados de las alternativas al alquiler',
                                    'Adecuacion, mejora, reparacion y/o mantenimiento de instalaciones y equipos NO relacionados con la eficiencia Energetica' => 'Adecuacion, mejora, reparacion y/o mantenimiento de instalaciones y equipos NO relacionados con la eficiencia Energetica',
                                    'Equipamiento basico del Hogar' => 'Equipamiento basico del Hogar',
                                    'Roperia (Ropa, Zapatos, Uniformes, Lenceria del Hogar, etc.)' => 'Roperia (Ropa, Zapatos, Uniformes, Lenceria del Hogar, etc.)',
                                    'Reparacion de Vehiculo' => 'Reparacion de Vehiculo',
                                    'Otras nececidades basicas de vivienda' => 'Otras nececidades basicas de vivienda',
                                ],
                                'Gastos Relativos a la reduccion de la Brecha Digital' => [
                                    'Pago de Telefonia e Internet' => 'Pago de Telefonia e Internet',
                                    'Equipamiento Digital' => 'Equipamiento Digital',
                                    'Otras nececidades basicas de la brecha digital' => 'Otras nececidades basicas de la brecha digital',
                                ],
                                'Gastos Relativos a la Educacion y Formacion' => [
                                    'Material Escolar' => 'Material Escolar',
                                    'Servicios escolares (Aula Matinal, Aula de Medio dia, Comedor, Extraescolares, etc.)' => 'Servicios escolares (Aula Matinal, Aula de Medio dia, Comedor, Extraescolares, etc.)',
                                    'Gastos de Transporte' => 'Gastos de Transporte',
                                    'Otras nececidades basicas de educacion' => 'Otras nececidades basicas de educacion',
                                ],
                                'Gastos Relativos a la Salud' => [
                                    'Material farmaceutico(farmacos, copagos, etc.)' => 'Material farmaceutico(farmacos, copagos, etc.)',
                                    'Optica y ortopedia' => 'Optica y ortopedia',
                                    'Odontologia' => 'Odontologia',
                                    'Servicios terapeuticos' => 'Servicios terapeuticos',
                                    'Otras nececidades basicas de salud' => 'Otras nececidades basicas de salud',
                                ],
                                'Otras Necesidades Basicas' => [
                                    'Alimentacion e higiene' => 'Alimentacion e higiene',
                                    'Gastos de Transporte o Viajes' => 'Gastos de Transporte o Viajes',
                                    'Otras nececidades basicas' => 'Otras nececidades basicas',
                                ]
                            ]),
                        Forms\Components\Select::make('status')
                            ->label('Etapa')
                            ->options([
                                'En Estudio' => 'En Estudio',
                                'Aceptada' => 'Aceptada',
                                'Rechazada' => 'Rechazada',
                                'Terminada' => 'Terminada',
                            ]),
                        Forms\Components\Select::make('collaborator_id')
                            ->relationship('collaborator', 'name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->label('Colaborador'),
                    ]),
                Fieldset::make('Fecha y Cantidad')
                    ->schema([
                        Forms\Components\DatePicker::make('start_date')
                            ->label('Fecha de Inicio'),
                        Forms\Components\DatePicker::make('end_date')
                            ->label('Fecha de Fin'),
                        Forms\Components\TextInput::make('approved_amount')
                            ->numeric()
                            ->inputMode('decimal')
                            ->prefixIcon('heroicon-o-currency-euro')
                            ->label('Importe mensual'),
                        Forms\Components\TextInput::make('total_amount')
                            ->numeric()
                            ->inputMode('decimal')
                            ->prefixIcon('heroicon-o-currency-euro')
                            ->label('Importe Total'),
                    ]),
                Fieldset::make('Notas')
                    ->schema([
                        Forms\Components\Textarea::make('notes')
                            ->maxLength(255)
                            ->default(null)
                            ->columnSpanFull()
                            ->label('Notas'),
                    ]),

            ]);
    }
    
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('type')
                    ->label('Tipo de Ayuda')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Etapa')
                    ->searchable(),
                Tables\Columns\TextColumn::make('beneficiary.name')
                    ->searchable()
                    ->numeric()
                    ->sortable()
                    ->label('Usuario'),
                Tables\Columns\TextColumn::make('volunteer.name')
                    ->numeric()
                    ->sortable()
                    ->label('Voluntario'),
                Tables\Columns\TextColumn::make('collaborator.name')
                    ->numeric()
                    ->sortable()
                    ->label('Colaborador'),
                Tables\Columns\TextColumn::make('start_date')
                    ->date()
                    ->sortable()
                    ->label('Fecha de Inicio')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('end_date')
                    ->date()
                    ->sortable()
                    ->label('Fecha de Fin')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('approved_amount')
                    ->numeric()
                    ->sortable()
                    ->label('Importe mensual')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('total_amount')
                    ->numeric()
                    ->sortable()
                    ->label('Importe Total')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('notes')
                    ->searchable()
                    ->label('Notas')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->label('Creado')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->label('Actualizado')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'En Estudio' => 'En Estudio',
                        'Aceptada' => 'Aceptada',
                        'Rechazada' => 'Rechazada',
                        'Terminada' => 'Terminada',
                    ])
                    ->attribute('status')
                    ->label('Etapa')
                    ->multiple(),
                Tables\Filters\SelectFilter::make('collaborator')
                    ->relationship('collaborator', 'name' , fn (Builder $query) => $query->whereIn('id', Aid::pluck('collaborator_id')->unique()))
                    ->searchable()
                    ->preload()
                    ->label('Colaborador'),
                    Tables\Filters\SelectFilter::make('type')
                    ->options(fn () => Aid::select('type')
                        ->distinct()
                        ->pluck('type', 'type')
                        ->toArray()
                        )
                    ->searchable()
                    ->preload()
                    ->label('Tipo de Ayuda'),

            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('pdf') 
                    ->label('PDF')
                    ->color('success')
                    ->icon('tabler-download')
                    ->action(function (Model $record) {
                        return response()->streamDownload(function () use ($record) {
                            echo FacadePdf::loadHtml(
                                Blade::render('pdf.receipt', ['record' => $record])
                            )->stream();
                        },'Ayuda de ' . $record->type .' a '. $record->Beneficiary->name . '.pdf');
                    })  , 
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
            'index' => Pages\ListAids::route('/'),
            'create' => Pages\CreateAid::route('/create'),
            'view' => Pages\ViewAid::route('/{record}'),
            'edit' => Pages\EditAid::route('/{record}/edit'),
        ];
    }
}
