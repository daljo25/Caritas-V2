<?php

namespace App\Filament\Resources\BeneficiaryResource\RelationManagers;

use App\Models\Family;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Parfaitementweb\FilamentCountryField\Forms\Components\Country;

class FamilyRelationManager extends RelationManager
{
    protected static string $relationship = 'Family';
    protected static ?string $label = 'Familiares';
    protected static ?string $title = 'Familiares';
    

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('Tabs')
                    ->tabs([
                        Tabs\Tab::make('Datos del Familiar')
                            ->icon('tabler-user')
                            ->schema([
                                
                                Fieldset::make('Datos Personales')
                                    ->schema([
                                        // datos del familiar
                                        Forms\Components\TextInput::make('name')
                                            ->label('Nombres y Apellidos')
                                            ->required()
                                            ->maxLength(255),
                                        Forms\Components\TextInput::make('dni')
                                            ->label('DNI / NIE / PAS')
                                            ->maxLength(255),
                                        Forms\Components\DatePicker::make('expiration_date')
                                            ->label('Fecha de Vencimiento'),
                                        Country::make('nationality')
                                            ->label('Nacionalidad')
                                            ->searchable(),
                                        Forms\Components\DatePicker::make('birth_date')
                                            ->label('Fecha de Nacimiento'),
                                        Forms\Components\Select::make('relationship')
                                            ->label('Parentesco')
                                            ->options([
                                                'Esposo/a' => 'Esposo/a',
                                                'Hijo' => 'Hijo',
                                                'Hija' => 'Hija',
                                                'Madre' => 'Madre',
                                                'Padre' => 'Padre',
                                                'Hermano/a' => 'Hermano/a',
                                                'Primo/a' => 'Primo/a',
                                                'Tio/a' => 'Tio/a',
                                                'Sobrino/a' => 'Sobrino/a',
                                                'Otro' => 'Otro',
                                            ]),
                                        Forms\Components\TextInput::make('phone')
                                            ->label('Teléfono')
                                            ->tel()
                                            ->maxLength(255),
                                        Forms\Components\TextInput::make('email')
                                            ->label('Correo Electrónico')
                                            ->email()
                                            ->maxLength(255),
                                        Forms\Components\TextInput::make('education')
                                            ->label('Nivel de Educación')
                                            ->maxLength(255),
                                    ])
                            ])
                            ->columns(2),
                        Tabs\Tab::make('Documentos')
                            ->icon('tabler-file-type-doc')
                            ->schema([
                                Fieldset::make('Informe de Vida Laboral')
                                    ->schema([
                                        //documentos ivl
                                        Forms\Components\DatePicker::make('ivl_emission_date')
                                            ->label('Fecha de Emisión'),
                                        Forms\Components\DatePicker::make('ivl_alta_date')
                                            ->label('Fecha de Alta'),
                                        Forms\Components\DatePicker::make('ivl_baja_date')
                                            ->label('Fecha de Baja'),
                                    ])
                                    ->columns(3),
                                Fieldset::make('Certificado de Pensionista')
                                    ->schema([
                                        //documentos cdp
                                        Forms\Components\DatePicker::make('cdp_emission_date')
                                            ->label('Fecha de Emisión'),
                                        Forms\Components\Toggle::make('cdp_state')
                                            ->label('Negativo o Positivo')
                                            ->onColor('success')
                                            ->offColor('danger')
                                            ->inline(false)
                                            ->live(),
                                        Forms\Components\TextInput::make('cdp_amount')
                                            ->label('Monto')
                                            ->numeric()
                                            ->inputMode('decimal')
                                            ->prefixIcon('heroicon-o-currency-euro')
                                            ->visible(fn (Get $get): bool => $get('cdp_state')),
                                    ])
                                    ->columns(3),
                                Fieldset::make('SEPE')
                                    ->schema([
                                        //documentos sepe
                                        Forms\Components\DatePicker::make('sepe_emission_date')
                                            ->label('Fecha de Emisión'),
                                        Forms\Components\Toggle::make('sepe_state')
                                            ->label('Negativo o Positivo')
                                            ->onColor('success')
                                            ->offColor('danger')
                                            ->inline(false)
                                            ->live(),
                                        Forms\Components\TextInput::make('sepe_amount')
                                            ->label('Monto')
                                            ->numeric()
                                            ->inputMode('decimal')
                                            ->prefixIcon('heroicon-o-currency-euro')
                                            ->visible(fn (Get $get): bool => $get('sepe_state')),
                                    ])
                                    ->columns(3),
                                Fieldset::make('Renta Minima Vital')
                                    ->schema([
                                        //documentos rmv
                                        Forms\Components\DatePicker::make('rmv_emission_date')
                                            ->label('Fecha de Emisión'),
                                        Forms\Components\Toggle::make('rmv_state')
                                            ->label('Negativo o Positivo')
                                            ->onColor('success')
                                            ->offColor('danger')
                                            ->inline(false)
                                            ->live(),
                                        Forms\Components\TextInput::make('rmv_amount')
                                            ->label('Monto')
                                            ->numeric()
                                            ->inputMode('decimal')
                                            ->prefixIcon('heroicon-o-currency-euro')
                                            ->visible(fn (Get $get): bool => $get('rmv_state')),
                                    ])
                                    ->columns(3),
                                Fieldset::make('REMISA')
                                    ->schema([
                                        //documentos remisa
                                        Forms\Components\DatePicker::make('remisa_emission_date')
                                            ->label('Fecha de Emisión'),
                                        Forms\Components\Toggle::make('remisa_state')
                                            ->label('Negativo o Positivo')
                                            ->onColor('success')
                                            ->offColor('danger')
                                            ->inline(false)
                                            ->live(),
                                        Forms\Components\TextInput::make('remisa_amount')
                                            ->label('Monto')
                                            ->numeric()
                                            ->inputMode('decimal')
                                            ->prefixIcon('heroicon-o-currency-euro')
                                            ->visible(fn (Get $get): bool => $get('remisa_state')),
                                    ])
                                    ->columns(3),
                            ])
                            ->columns(2),
                    ])
                    ->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nombres y Apellidos'),
                Tables\Columns\TextColumn::make('dni')
                    ->label('DNI / NIE / PAS'),
                Tables\Columns\TextColumn::make('birth_date')
                    ->label('Fecha de Nacimiento')
                    ->date()
                    ->sortable(),
                    Tables\Columns\TextColumn::make('age')
                    ->label('Edad')
                    ->sortable()
                    ->state(function (Family $record): ?string{
                        return Carbon::parse($record->birth_date)->age;
                    })
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('relationship')
                    ->label('Parentesco'),
                Tables\Columns\TextColumn::make('phone')
                    ->label('Teléfono'),
                Tables\Columns\TextColumn::make('email')
                    ->label('Correo Electrónico'),
                Tables\Columns\TextColumn::make('education')
                    ->label('Nivel de Educación'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                //Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
