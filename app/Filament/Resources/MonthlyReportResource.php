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
                                'Enero' => 'Enero',
                                'Febrero' => 'Febrero',
                                'Marzo' => 'Marzo',
                                'Abril' => 'Abril',
                                'Mayo' => 'Mayo',
                                'Junio' => 'Junio',
                                'Julio' => 'Julio',
                                'Agosto' => 'Agosto',
                                'Septiembre' => 'Septiembre',
                                'Octubre' => 'Octubre',
                                'Noviembre' => 'Noviembre',
                                'Diciembre' => 'Diciembre',
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
                            ->label('Recaudacion en la Colecta')
                            ->inputMode('decimal')
                            ->prefixIcon('heroicon-o-currency-euro')
                            ->reactive()
                            ->afterStateUpdated(function (Set $set, Get $get) {
                                $collection = (float) $get('collection');
                                $membership_receipts = (float) $get('membership_receipts');
                
                                // Calcular el 50% de collection + 50% de membership_receipts
                                $charity_transfer = 0.5 * ($collection + $membership_receipts);
                
                                // Actualizar el campo charity_transfer
                                $set('charity_transfer', $charity_transfer);
                            }),
                        Forms\Components\TextInput::make('donation_by_bank')
                            ->numeric()
                            ->label('Donativos por Banco')
                            ->inputMode('decimal')
                            ->prefixIcon('heroicon-o-currency-euro'),
                        Forms\Components\TextInput::make('membership_receipts')
                            ->numeric()
                            ->label('Recibos de Socios Cobrados')
                            ->inputMode('decimal')
                            ->prefixIcon('heroicon-o-currency-euro')
                            ->reactive()
                            ->afterStateUpdated(function (Set $set, Get $get) {
                                $collection = (float) $get('collection');
                                $membership_receipts = (float) $get('membership_receipts');
                
                                // Calcular el 50% de collection + 50% de membership_receipts
                                $charity_transfer = 0.5 * ($collection + $membership_receipts);
                
                                // Actualizar el campo charity_transfer
                                $set('charity_transfer', $charity_transfer);
                            }),
                        Forms\Components\TextInput::make('charity_receipts')
                            ->numeric()
                            ->label('Recibos de Caritas Diosesana')
                            ->inputMode('decimal')
                            ->prefixIcon('heroicon-o-currency-euro')
                            ->hintIcon('tabler-help', tooltip: '50% de los recibos cobrados por CD'),   
                    ]),
                Fieldset::make('Gastos')
                    ->schema([
                        Forms\Components\TextInput::make('charity_transfer')
                            ->label('Transferencia Hecha al Fondo Comun Diosesano')
                            ->numeric()
                            ->inputMode('decimal')
                            ->prefixIcon('heroicon-o-currency-euro')
                            ->hintIcon('tabler-help', tooltip: '50% de la Colecta + 50% de los recibos cobrados por nosotros')
                            ->reactive()
                            ->readOnly(true),
                        Forms\Components\TextInput::make('food')
                            ->numeric()
                            ->label('Gastos para Alimentacion e Higiene Personal')
                            ->inputMode('decimal')
                            ->prefixIcon('heroicon-o-currency-euro'),
                        Forms\Components\TextInput::make('supplies_receipt')
                            ->numeric()
                            ->label('Gastos de Recibos de Suministros')
                            ->inputMode('decimal')
                            ->prefixIcon('heroicon-o-currency-euro')
                            ->hintIcon('tabler-help', tooltip: 'Recibos de Comunidad, Electricidad, Agua, Gas, Telefonia'),
                        Forms\Components\TextInput::make('bank')
                            ->numeric()
                            ->label('Gastos Bancarios')
                            ->inputMode('decimal')
                            ->prefixIcon('heroicon-o-currency-euro'),
                        Forms\Components\TextInput::make('housing')
                            ->numeric()
                            ->label('Gastos en Vivienda')
                            ->inputMode('decimal')
                            ->prefixIcon('heroicon-o-currency-euro')
                            ->hintIcon('tabler-help', tooltip: 'Alquileres, Hipotecas, Equipamiento de Vivienda'),
                        Forms\Components\TextInput::make('other_interventions')
                            ->numeric()
                            ->label('Otras Intervenciones')
                            ->inputMode('decimal')
                            ->prefixIcon('heroicon-o-currency-euro')
                            ->hintIcon('tabler-help', tooltip: 'Material Escolar, Proyectos de Trabajo, Cursos, Bonobus, etc.'),
                        Forms\Components\TextInput::make('health')
                            ->numeric()
                            ->label('Gastos en Salud')
                            ->inputMode('decimal')
                            ->prefixIcon('heroicon-o-currency-euro')
                            ->hintIcon('tabler-help', tooltip: 'Medicamentos, Ortopedia, Optica, ortodoncia, etc.'),
                        Forms\Components\TextInput::make('guests')
                            ->numeric()
                            ->label('Transeuntes')
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
                        },'Comunicado Mensual '.$record->month.' '.$record->year .'.pdf');
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
