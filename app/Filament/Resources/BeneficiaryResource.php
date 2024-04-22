<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BeneficiaryResource\Pages;
use App\Filament\Resources\BeneficiaryResource\RelationManagers;
use App\Models\Beneficiary;
use Barryvdh\DomPDF\PDF;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
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
use Filament\Forms\Get;
use Filament\Resources\RelationManagers\RelationManager;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Blade;
use Parfaitementweb\FilamentCountryField\Forms\Components\Country;

class BeneficiaryResource extends Resource
{
    protected static ?string $model = Beneficiary::class;
    protected static ?string $navigationGroup = 'Usuarios';
    protected static ?string $label = 'Usuario';
    protected static ?string $navigationIcon = 'tabler-user-circle';
    protected static ?string $recordTitleAttribute = 'Usuarios';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('Tabs')
                    ->tabs([
                        Tabs\Tab::make('Datos del Usuario')
                            ->icon('tabler-user')
                            ->schema([
                                Fieldset::make('Voluntario')
                                    ->schema([
                                        // voluntario y estado
                                        Forms\Components\Select::make('volunteer_id')
                                            ->required()
                                            ->relationship('Volunteer', 'name')
                                            ->searchable()
                                            ->preload()
                                            ->label('Voluntario'),
                                        Forms\Components\Select::make('state')
                                            ->required()
                                            ->hiddenOn('create')
                                            ->default('Activo')
                                            ->label('Estado')
                                            ->options([
                                                'Activo' => 'Activo',
                                                'Pasivo' => 'Pasivo',
                                                'Archivado' => 'Archivado',
                                            ]),
                                    ]),
                                Fieldset::make('Datos Personales')
                                    ->schema([
                                        // datos del Usuario
                                        Forms\Components\TextInput::make('name')
                                            ->required()
                                            ->maxLength(255)
                                            ->label('Nombres y Apellidos'),
                                        Forms\Components\TextInput::make('expedient')
                                            ->maxLength(255)
                                            ->label('Nº de Expediente'),
                                        Forms\Components\TextInput::make('dni')
                                            ->maxLength(255)
                                            ->label('DNI / NIE / PAS'),
                                        Forms\Components\DatePicker::make('expiration_date')
                                            ->label('Fecha de Vencimiento'),
                                        Country::make('nationality')
                                            ->label('Nacionalidad')
                                            ->searchable(),
                                        Forms\Components\DatePicker::make('birth_date')
                                            ->label('Fecha de Nacimiento'),
                                        Forms\Components\TextInput::make('address')
                                            ->label('Dirección')
                                            ->maxLength(255),
                                        Forms\Components\TextInput::make('phone')
                                            ->label('Número de Telefono')
                                            ->tel()
                                            ->maxLength(255),
                                        Forms\Components\TextInput::make('email')
                                            ->label('Correo Electronico')
                                            ->email()
                                            ->maxLength(255),
                                        Forms\Components\TextInput::make('education')
                                            ->label('Nivel de Educación')
                                            ->maxLength(255),
                                    ]),
                                Fieldset::make('Datos Socioeconomicos')
                                    ->schema([
                                        // datos socioeconomicos
                                        Forms\Components\Select::make('housing_type')
                                            ->label('Tipo de Vivienda')
                                            ->options([
                                                'Propia' => 'Propia',
                                                'Alquilada' => 'Alquilada',
                                                'Familiar' => 'Familiar',
                                                'Cedida' => 'Cedida',
                                                'Ocupada' => 'Ocupada',
                                            ]),
                                        Forms\Components\TextInput::make('incomes')
                                            ->label('Ingresos')
                                            ->numeric()
                                            ->inputMode('decimal')
                                            ->prefixIcon('heroicon-o-currency-euro'),
                                        Forms\Components\TextInput::make('light')
                                            ->label('Luz')
                                            ->numeric()
                                            ->inputMode('decimal')
                                            ->prefixIcon('heroicon-o-currency-euro'),
                                        Forms\Components\TextInput::make('water')
                                            ->label('Agua')
                                            ->numeric()
                                            ->inputMode('decimal')
                                            ->prefixIcon('heroicon-o-currency-euro'),
                                        Forms\Components\TextInput::make('rent')
                                            ->label('Alquiler/Hipoteca')
                                            ->numeric()
                                            ->inputMode('decimal')
                                            ->prefixIcon('heroicon-o-currency-euro'),
                                        Forms\Components\TextInput::make('community')
                                            ->label('Comunidad')
                                            ->numeric()
                                            ->inputMode('decimal')
                                            ->prefixIcon('heroicon-o-currency-euro'),
                                        Forms\Components\TextInput::make('others')
                                            ->label('Otros')
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
                                            ->label('Libro de Familia')
                                            ->onColor('success')
                                            ->offColor('danger')
                                            ->inline(false),
                                        Forms\Components\Toggle::make('rent_contract')
                                            ->label('Contrato de Alquiler')
                                            ->onColor('success')
                                            ->offColor('danger')
                                            ->inline(false),
                                        Forms\Components\DatePicker::make('census_emission_date')
                                            ->label('Padron Municipal'),
                                        Forms\Components\TextInput::make('social_assistance_name')
                                            ->label('Asistente Social')
                                            ->maxLength(255),
                                    ]),
                                Fieldset::make('Informe de Vida Laboral')
                                    ->schema([
                                        //documentos ivl
                                        Forms\Components\DatePicker::make('ivl_emission_date')
                                            ->label('Fecha de Emision'),
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
                                            ->label('Fecha de Emision'),
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
                                            ->label('Fecha de Emision'),
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
                                            ->label('Fecha de Emision'),
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
                                            ->label('Fecha de Emision'),
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
                    ->label('Voluntario')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('name')
                    ->label('Nombres y Apellidos')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('expedient')
                    ->label('Exp')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('dni')
                    ->label('DNI / NIE / PAS')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('expiration_date')
                    ->label('Fecha de Vencimiento')
                    ->date()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('nationality')
                    ->label('Nacionalidad')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('birth_date')
                    ->label('Fecha de Nacimiento')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('age')
                    ->label('Edad')
                    ->sortable()
                    ->state(function (Beneficiary $record): ?string{
                        return Carbon::parse($record->birth_date)->age;
                    })
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('address')
                    ->label('Dirección')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('phone')
                    ->label('Teléfono')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('Correo Electrónico')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('education')
                    ->label('Nivel de Educación')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('state')
                    ->label('Estado')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('state')
                    ->options([
                        'Activo' => 'Activo',
                        'Pasivo' => 'Pasivo',
                        'Archivado' => 'Archivado',
                    ])
                    ->label('Estado')
                    ->attribute('state')
                    ->multiple(),
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
                                Blade::render('pdf.intervention', ['record' => $record])
                            )->stream();
                        },'Hoja de Intervención de ' . $record->name . '.pdf');
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
