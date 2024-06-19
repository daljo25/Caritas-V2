<?php

namespace App\Filament\Resources\DonorResource\Pages;

use App\Exports\DonationsExport;
use App\Filament\Resources\DonorResource;
use App\Models\Donation;
use App\Models\Donor;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Blade;
use Maatwebsite\Excel\Facades\Excel as FacadesExcel;

class ListDonors extends ListRecords
{
    protected static string $resource = DonorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('export')
                ->label('Listado de Donantes')
                ->color('info')
                ->icon('tabler-file-type-xls')
                ->modalSubmitActionLabel('Exportar')
                ->modalFooterActionsAlignment('center')
                ->modalCancelAction(false)
                ->form([
                    Fieldset::make('Filtros')->columnSpan(2)->schema([
                        Select::make('donor_name')
                            ->label('Nombre')
                            ->multiple()
                            ->options(Donor::query()->get()->pluck('name', 'name')->unique()->toArray()),
                        Select::make('source')
                            ->label('Medio de Donación')
                            ->multiple()
                            ->options(Donation::query()->get()->pluck('source', 'source')->unique()->toArray()),
                        Select::make('donation_month')
                            ->label('Mes')
                            ->multiple()
                            ->options(Donation::query()->get()->pluck('donation_month', 'donation_month')->unique()->toArray()),
                        Select::make('donation_year')
                            ->label('Año')
                            ->multiple()
                            ->options(Donation::query()->get()->pluck('donation_year', 'donation_year')->unique()->toArray()),
                    ]),
                    TextInput::make('filename')
                        ->label('Nombre del Archivo')
                        ->placeholder('Lista de Donaciones')
                        ->suffix('.xlsx'),
                ])
                ->action(function (array $data) {
                    // Procesar los datos del formulario
                    $filters = [
                        'donor_name' => $data['donor_name'] ?? [],
                        'source' => $data['source'] ?? [],
                        'donation_month' => $data['donation_month'] ?? [],
                        'donation_year' => $data['donation_year'] ?? [],
                    ];

                    // Crear una instancia de DonationsExport con los filtros proporcionados
                    $export = new DonationsExport($filters);
                    $filename = $data['filename'] ?? 'Lista de Donaciones';
                    // Descargar el archivo de Excel
                    return FacadesExcel::download($export, $filename . '.xlsx');
                }),
            Action::make('pdf')
                ->label('Donaciones Anuales')
                ->color('success')
                ->icon('tabler-file-type-pdf')
                ->form([
                    Select::make('donation_year')
                        ->label('Año')
                        ->options(Donation::query()->pluck('donation_year', 'donation_year')->unique()->toArray())
                ])
                ->action(function (array $data) {
                    // Obtener el año de donaciones
                    $year = $data['donation_year'];

                    // Obtener las donaciones del año seleccionado
                    $donations = Donation::where('donation_year', $year)
                        ->with('donor')
                        ->get()
                        ->groupBy('donor_id');

                    // Renderizar la vista Blade y generar el PDF
                    $pdfContent = Blade::render('pdf.donors', ['donations' => $donations, 'year' => $year]);
                    $pdf = FacadePdf::loadHtml($pdfContent)
                        ->setPaper('a4', 'landscape');

                    // Enviar el PDF al navegador para su descarga
                    return response()->streamDownload(function () use ($pdf) {
                        echo $pdf->stream();
                    }, 'Donaciones_Anuales_' . $year . '.pdf',);
                }),
            Actions\CreateAction::make(),
        ];
    }
}
