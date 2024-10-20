<?php

namespace App\Filament\Resources\AppointmentResource\Pages;

use App\Filament\Resources\AppointmentResource;
use App\Models\Appointment;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Blade;

class ListAppointments extends ListRecords
{
    protected static string $resource = AppointmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('pdf')
                ->label('Listado de Citas')
                ->color('success')
                ->icon('tabler-file-type-pdf')
                ->form([
                    DatePicker::make('appointment_date')
                        ->label('Seleccione un día')
                        ->required()
                ])
                ->action(function (array $data) {
                    // Obtener el día de la fecha seleccionada
                    $day = $data['appointment_date'];

                    // Obtener las citas del día seleccionado
                    $appointments = Appointment::where('appointment_date', $day)
                        ->with('beneficiary')
                        ->where('status', 'Aceptada')
                        ->orderBy('appointment_time', 'asc')
                        ->get();

                    // Obtener las otras citas con fecha distintal al seleccionado y estado distinto a aceptada
                    $otherAppointments = Appointment::where(function ($query) use ($day) {
                        $query->where('appointment_date', '!=', $day)
                            ->orWhereNull('appointment_date');
                    })
                        ->where('status', '!=', 'Aceptada')
                        ->where('status', '!=', 'Atendida')
                        ->with('beneficiary')
                        ->orderBy('appointment_date', 'asc')
                        ->get();

                    // Verificar que se obtuvieron citas
                    if ($appointments->isEmpty()) {
                        // Manejar el caso en el que no hay citas
                        Notification::make()
                            ->title('No hay Citas para el día seleccionado')
                            ->danger()
                            ->send();
                        return;
                    }

                    // Renderizar la vista Blade y generar el PDF
                    $pdfContent = view('pdf.appointments', ['appointments' => $appointments, 'day' => $day, 'otherAppointments' => $otherAppointments])->render();
                    $pdf = Pdf::loadHtml($pdfContent)
                        ->setPaper('a4', 'landscape');

                    // Enviar el PDF al navegador para su descarga
                    return response()->streamDownload(function () use ($pdf) {
                        echo $pdf->stream();
                    }, 'Citas_del_' . $day . '.pdf');
                }),
            Actions\CreateAction::make(),
        ];
    }
}
