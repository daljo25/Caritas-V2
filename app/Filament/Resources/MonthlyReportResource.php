<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MonthlyReportResource\Pages;
use Filament\Forms\Get;
use App\Filament\Resources\MonthlyReportResource\RelationManagers;
use App\Models\MonthlyReport;
use Filament\Forms;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Blade;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;

class MonthlyReportResource extends Resource
{
    protected static ?string $model = MonthlyReport::class;
    protected static ?string $navigationGroup = 'Administracion';
    protected static ?string $label = 'Reporte Mensual';
    protected static ?string $navigationIcon = 'tabler-calendar-month';
    protected static ?string $recordTitleAttribute = 'Reporte Mensual';
    protected static ?string $pluralLabel = 'Reportes Mensuales';
    protected static ?int $navigationSort = 8;


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Fieldset::make('Fecha del Reporte')
                    ->schema([
                        Forms\Components\Select::make('month')
                            ->label('Mes')
                            ->required()
                            ->options([
                                '01' => 'Enero',
                                '02' => 'Febrero',
                                '03' => 'Marzo',
                                '04' => 'Abril',
                                '05' => 'Mayo',
                                '06' => 'Junio',
                                '07' => 'Julio',
                                '08' => 'Agosto',
                                '09' => 'Septiembre',
                                '10' => 'Octubre',
                                '11' => 'Noviembre',
                                '12' => 'Diciembre',
                            ]),
                        Forms\Components\Select::make('year')
                            ->label('Año')
                            ->required()
                            ->options([
                                '2024' => '2024',
                                '2025' => '2025',
                                '2026' => '2026',
                                '2027' => '2027',
                            ]),
                    ]),
                Fieldset::make('Ingresos')
                    ->schema([
                        Forms\Components\TextInput::make('collection')
                            ->numeric()
                            ->label('Colectas')
                            ->inputMode('decimal')
                            ->prefixIcon('heroicon-o-currency-euro'),
                        Forms\Components\TextInput::make('parroquial_receipt')
                            ->numeric()
                            ->label('Recibos de Socios Cobrados')
                            ->inputMode('decimal')
                            ->prefixIcon('heroicon-o-currency-euro'),
                        Forms\Components\TextInput::make('bank_donation')
                            ->numeric()
                            ->label('Donativos por Banco')
                            ->inputMode('decimal')
                            ->prefixIcon('heroicon-o-currency-euro'),
                        Forms\Components\TextInput::make('volunteer_campaign_donation')
                            ->numeric()
                            ->label('Campañas (Socios/Voluntarios)')
                            ->inputMode('decimal')
                            ->prefixIcon('heroicon-o-currency-euro'),
                        Forms\Components\TextInput::make('diosesano_receipt')
                            ->numeric()
                            ->label('Recibos Cobrados por Caritas Diosesana')
                            ->inputMode('decimal')
                            ->prefixIcon('heroicon-o-currency-euro'),
                        Forms\Components\TextInput::make('diosesano_donation')
                            ->numeric()
                            ->label('Dinero recibido de Caritas Diosesana')
                            ->inputMode('decimal')
                            ->prefixIcon('heroicon-o-currency-euro'),
                        Forms\Components\TextInput::make('other_donation')
                            ->numeric()
                            ->label('Recibido de Otras Entidades')
                            ->inputMode('decimal')
                            ->prefixIcon('heroicon-o-currency-euro'),
                        Forms\Components\TextInput::make('special_donation')
                            ->numeric()
                            ->label('Donaciones en Especie')
                            ->inputMode('decimal')
                            ->prefixIcon('heroicon-o-currency-euro'),
                    ]),
                Fieldset::make('Gastos')
                    ->schema([
                        Forms\Components\TextInput::make('transfer_collection')
                            ->label('Transferencia al Fondo Comun Diosesano por Colectas')
                            ->numeric()
                            ->inputMode('decimal')
                            ->prefixIcon('heroicon-o-currency-euro'),
                        Forms\Components\TextInput::make('transfer_membership')
                            ->label('Transferencia al Fondo Comun Diosesano por Recibos de Socios')
                            ->numeric()
                            ->inputMode('decimal')
                            ->prefixIcon('heroicon-o-currency-euro'),
                        Forms\Components\TextInput::make('transfer_campaign')
                            ->label('Transferencia al Fondo Comun Diosesano por Campañas')
                            ->numeric()
                            ->inputMode('decimal')
                            ->prefixIcon('heroicon-o-currency-euro'),
                        Forms\Components\TextInput::make('transfer_other')
                            ->label('Transferencia al Fondo Comun Diosesano por Otros Conceptos')
                            ->numeric()
                            ->inputMode('decimal')
                            ->prefixIcon('heroicon-o-currency-euro'),
                        Forms\Components\TextInput::make('transfer_arciprestal')
                            ->label('Transferencia al Arciprestal')
                            ->numeric()
                            ->inputMode('decimal')
                            ->prefixIcon('heroicon-o-currency-euro'),
                        Forms\Components\TextInput::make('health')
                            ->numeric()
                            ->label('Gastos de Salud (medicamentos, ortopedia, optica, ortodoncia, etc)')
                            ->inputMode('decimal')
                            ->prefixIcon('heroicon-o-currency-euro'),
                        Forms\Components\TextInput::make('housing')
                            ->numeric()
                            ->label('Gastos en Vivienda (alquileres, hipotecas, equipamiento de vivienda)')
                            ->inputMode('decimal')
                            ->prefixIcon('heroicon-o-currency-euro'),
                        Forms\Components\TextInput::make('food')
                            ->numeric()
                            ->label('Gastos para Alimentacion e Higiene Personal')
                            ->inputMode('decimal')
                            ->prefixIcon('heroicon-o-currency-euro'),
                        Forms\Components\TextInput::make('supplies_receipt')
                            ->numeric()
                            ->label('Gastos de Recibos de Suministros Basicos (comunidad, electricidad, agua, gas)')
                            ->inputMode('decimal')
                            ->prefixIcon('heroicon-o-currency-euro'),
                        Forms\Components\TextInput::make('other_intervention')
                            ->numeric()
                            ->label('Otras Intervenciones (material escolar, proyectos de trabajo, bonobus, etc)')
                            ->inputMode('decimal')
                            ->prefixIcon('heroicon-o-currency-euro'),
                        Forms\Components\TextInput::make('parish_project')
                            ->numeric()
                            ->label('Proyectos Especificos Parroquiales')
                            ->inputMode('decimal')
                            ->prefixIcon('heroicon-o-currency-euro'),
                        Forms\Components\TextInput::make('general_expense')
                            ->numeric()
                            ->label('Gastos Generales Internos (mantenimiento, banco, etc)')
                            ->inputMode('decimal')
                            ->prefixIcon('heroicon-o-currency-euro'),
                        Forms\Components\TextInput::make('other_entity')
                            ->numeric()
                            ->label('Transferencias a Otras Entidades')
                            ->inputMode('decimal')
                            ->prefixIcon('heroicon-o-currency-euro'),
                        Forms\Components\TextInput::make('campaign_volunteers')
                            ->numeric()
                            ->label('Campañas (Socios/Voluntarios)')
                            ->inputMode('decimal')
                            ->prefixIcon('heroicon-o-currency-euro'),
                        Forms\Components\TextInput::make('campaign_local_emergency')
                            ->numeric()
                            ->label('Campañas (Emergencias Locales)')
                            ->inputMode('decimal')
                            ->prefixIcon('heroicon-o-currency-euro'),
                        Forms\Components\TextInput::make('campaign_international_emergency')
                            ->numeric()
                            ->label('Campañas (Emergencias Internacionales)')
                            ->inputMode('decimal')
                            ->prefixIcon('heroicon-o-currency-euro'),
                        Forms\Components\TextInput::make('development_cooperation')
                            ->numeric()
                            ->label('Cooperación al Desarrollo')
                            ->inputMode('decimal')
                            ->prefixIcon('heroicon-o-currency-euro'),

                    ]),
                Fieldset::make('Mensaje')
                    ->schema([
                        Forms\Components\RichEditor::make('message')
                            ->label('Mensaje')
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('month')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('year')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('message')
                    ->label('Incidente')
                    ->words(20)
                    ->wrap()
                    ->html(),
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
                                Blade::render('pdf.monthly-report', ['record' => $record])
                            )->stream();
                        }, 'Comunicado Mensual mes ' . $record->month . ' año ' . $record->year . '.pdf');
                    })
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
            'index' => Pages\ListMonthlyReports::route('/'),
            'create' => Pages\CreateMonthlyReport::route('/create'),
            'edit' => Pages\EditMonthlyReport::route('/{record}/edit'),
        ];
    }
}
