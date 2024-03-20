<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BeneficiaryResource\Pages;
use App\Filament\Resources\BeneficiaryResource\RelationManagers;
use App\Models\Beneficiary;
use Closure;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Fieldset;
use Filament\Resources\RelationManagers\RelationManager;
use Parfaitementweb\FilamentCountryField\Forms\Components\Country;

class BeneficiaryResource extends Resource
{
    protected static ?string $model = Beneficiary::class;
    protected static ?string $navigationGroup = 'Beneficiarios';
    protected static ?string $label = 'Beneficiario';
    protected static ?string $navigationIcon = 'tabler-user-circle';
    protected static ?string $recordTitleAttribute = 'Beneficiarios';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('Tabs')
                    ->tabs([
                        Tabs\Tab::make('Datos del beneficiario')
                            ->icon('tabler-user')
                            ->schema([
                                Fieldset::make('Voluntario')
                                    ->schema([
                                        // voluntario y estado
                                        Forms\Components\Select::make('volunteer_id')
                                            ->required()
                                            ->relationship('Volunteer', 'name')
                                            ->searchable()
                                            ->preload(),
                                        Forms\Components\Select::make('state')
                                            ->required()
                                            ->hiddenOn('create')
                                            ->default('Activo')
                                            ->options([
                                                'Activo' => 'Activo',
                                                'Pasivo' => 'Pasivo',
                                                'Archivado' => 'Archivado',
                                            ]),
                                    ]),
                                Fieldset::make('Datos Personales')
                                    ->schema([
                                        // datos del beneficiario
                                        Forms\Components\TextInput::make('name')
                                            ->required()
                                            ->maxLength(255),
                                        Forms\Components\TextInput::make('expedient')
                                            ->maxLength(255),
                                        Forms\Components\TextInput::make('dni')
                                            ->maxLength(255),
                                        Forms\Components\DatePicker::make('expiration_date'),
                                        Country::make('nationality')
                                            ->searchable(),
                                        Forms\Components\DatePicker::make('birth_date'),
                                        Forms\Components\TextInput::make('address')
                                            ->maxLength(255),
                                        Forms\Components\TextInput::make('phone')
                                            ->tel()
                                            ->maxLength(255),
                                        Forms\Components\TextInput::make('email')
                                            ->email()
                                            ->maxLength(255),
                                        Forms\Components\TextInput::make('education')
                                            ->maxLength(255),
                                    ]),
                                Fieldset::make('Datos Socioeconomicos')
                                    ->schema([
                                        // datos socioeconomicos
                                        Forms\Components\Select::make('housing_type')
                                            ->options([
                                                'Propia' => 'Propia',
                                                'Alquilada' => 'Alquilada',
                                                'Familiar' => 'Familiar',
                                                'Cedida' => 'Cedida',
                                                'Ocupada' => 'Ocupada',
                                            ]),
                                        Forms\Components\TextInput::make('incomes')
                                            ->numeric()
                                            ->inputMode('decimal')
                                            ->prefixIcon('heroicon-o-currency-euro'),
                                        Forms\Components\TextInput::make('light')
                                            ->numeric()
                                            ->inputMode('decimal')
                                            ->prefixIcon('heroicon-o-currency-euro'),
                                        Forms\Components\TextInput::make('water')
                                            ->numeric()
                                            ->inputMode('decimal')
                                            ->prefixIcon('heroicon-o-currency-euro'),
                                        Forms\Components\TextInput::make('rent')
                                            ->numeric()
                                            ->inputMode('decimal')
                                            ->prefixIcon('heroicon-o-currency-euro'),
                                        Forms\Components\TextInput::make('community')
                                            ->numeric()
                                            ->inputMode('decimal')
                                            ->prefixIcon('heroicon-o-currency-euro'),
                                        Forms\Components\TextInput::make('others')
                                            ->numeric()
                                            ->inputMode('decimal')
                                            ->prefixIcon('heroicon-o-currency-euro'),
                                    ]),
                            ]),
                        Tabs\Tab::make('Documentos')
                            ->icon('tabler-file-type-doc')
                            ->schema([
                                Fieldset::make('Documentos Generales')
                                    ->schema([
                                        //documentos generales
                                        Forms\Components\Toggle::make('family_book')
                                            ->onColor('success')
                                            ->offColor('danger')
                                            ->inline(false),
                                        Forms\Components\Toggle::make('rent_contract')
                                            ->onColor('success')
                                            ->offColor('danger')
                                            ->inline(false),
                                        Forms\Components\DatePicker::make('census_emission_date'),
                                        Forms\Components\TextInput::make('social_assistance_name')
                                            ->maxLength(255),
                                    ]),
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
                            ]),
                    ])
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('volunteer.name')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('expedient')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('dni')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('expiration_date')
                    ->date()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('nationality')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('birth_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('age')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('address')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('phone')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('education')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('state')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            RelationManagers\FamilyRelationManager::class,
            RelationManagers\RecordRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBeneficiaries::route('/'),
            'create' => Pages\CreateBeneficiary::route('/create'),
            'view' => Pages\ViewBeneficiary::route('/{record}'),
            'edit' => Pages\EditBeneficiary::route('/{record}/edit'),
        ];
    }
}
