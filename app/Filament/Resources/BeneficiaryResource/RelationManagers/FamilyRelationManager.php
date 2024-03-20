<?php

namespace App\Filament\Resources\BeneficiaryResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Parfaitementweb\FilamentCountryField\Forms\Components\Country;

class FamilyRelationManager extends RelationManager
{
    protected static string $relationship = 'Family';

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
                                            ->required()
                                            ->maxLength(255),
                                        Forms\Components\TextInput::make('dni')
                                            ->maxLength(255),
                                        Forms\Components\DatePicker::make('expiration_date'),
                                        Country::make('nationality')
                                            ->searchable(),
                                        Forms\Components\DatePicker::make('birth_date'),
                                        Forms\Components\Select::make('relationship')
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
                                            ->tel()
                                            ->maxLength(255),
                                        Forms\Components\TextInput::make('email')
                                            ->email()
                                            ->maxLength(255),
                                        Forms\Components\TextInput::make('education')
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
                                        Forms\Components\DatePicker::make('ivl_emission_date'),
                                        Forms\Components\DatePicker::make('ivl_alta_date'),
                                        Forms\Components\DatePicker::make('ivl_baja_date'),
                                    ])
                                    ->columns(3),
                                Fieldset::make('Certificado de Pensionista')
                                    ->schema([
                                        //documentos cdp
                                        Forms\Components\DatePicker::make('cdp_emission_date'),
                                        Forms\Components\Toggle::make('cdp_state')
                                            ->onColor('success')
                                            ->offColor('danger')
                                            ->inline(false),
                                        Forms\Components\TextInput::make('cdp_amount')
                                            ->numeric()
                                            ->inputMode('decimal')
                                            ->prefixIcon('heroicon-o-currency-euro'),
                                    ])
                                    ->columns(3),
                                Fieldset::make('SEPE')
                                    ->schema([
                                        //documentos sepe
                                        Forms\Components\DatePicker::make('sepe_emission_date'),
                                        Forms\Components\Toggle::make('sepe_state')
                                            ->onColor('success')
                                            ->offColor('danger')
                                            ->inline(false),
                                        Forms\Components\TextInput::make('sepe_amount')
                                            ->numeric()
                                            ->inputMode('decimal')
                                            ->prefixIcon('heroicon-o-currency-euro'),
                                    ])
                                    ->columns(3),
                                Fieldset::make('Renta Minima Vital')
                                    ->schema([
                                        //documentos rmv
                                        Forms\Components\DatePicker::make('rmv_emission_date'),
                                        Forms\Components\Toggle::make('rmv_state')
                                            ->onColor('success')
                                            ->offColor('danger')
                                            ->inline(false),
                                        Forms\Components\TextInput::make('rmv_amount')
                                            ->numeric()
                                            ->inputMode('decimal')
                                            ->prefixIcon('heroicon-o-currency-euro'),
                                    ])
                                    ->columns(3),
                                Fieldset::make('REMISA')
                                    ->schema([
                                        //documentos remisa
                                        Forms\Components\DatePicker::make('remisa_emission_date'),
                                        Forms\Components\Toggle::make('remisa_state')
                                            ->onColor('success')
                                            ->offColor('danger')
                                            ->inline(false),
                                        Forms\Components\TextInput::make('remisa_amount')
                                            ->numeric()
                                            ->inputMode('decimal')
                                            ->prefixIcon('heroicon-o-currency-euro'),
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
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('dni'),
                Tables\Columns\TextColumn::make('birth_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('relationship'),
                Tables\Columns\TextColumn::make('phone'),
                Tables\Columns\TextColumn::make('email'),
                Tables\Columns\TextColumn::make('education'),
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
