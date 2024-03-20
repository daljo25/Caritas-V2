<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FamilyResource\Pages;
use App\Filament\Resources\FamilyResource\RelationManagers;
use App\Models\Family;
use Filament\Forms;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Parfaitementweb\FilamentCountryField\Forms\Components\Country;

class FamilyResource extends Resource
{
    protected static ?string $model = Family::class;
    protected static ?string $navigationGroup = 'Beneficiarios';
    protected static ?string $label = 'Familiares';
    protected static ?string $navigationIcon = 'tabler-users-group';
    protected static ?string $recordTitleAttribute = 'Familiares';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('Tabs')
                    ->tabs([
                        Tabs\Tab::make('Datos del Familiar')
                            ->icon('tabler-user')
                            ->schema([
                                Fieldset::make('Beneficiario Titular')
                                    ->schema([
                                        // titular
                                        Forms\Components\Select::make('beneficiary_id')
                                            ->relationship('beneficiary', 'name')
                                            ->searchable()
                                            ->preload()
                                            ->required(),
                                    ]),
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

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('beneficiary.name')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('dni')
                    ->searchable(),
                Tables\Columns\TextColumn::make('birth_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('relationship')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('education')
                    ->searchable(),
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
            'index' => Pages\ListFamilies::route('/'),
            'create' => Pages\CreateFamily::route('/create'),
            'edit' => Pages\EditFamily::route('/{record}/edit'),
        ];
    }
}
