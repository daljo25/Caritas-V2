<?php

namespace App\Filament\Resources\AidResource\Pages;

use App\Filament\Resources\AidResource;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Blade;

class EditAid extends EditRecord
{
    protected static string $resource = AidResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('pdf')
                ->label('Recibí')
                ->color('success')
                ->icon('tabler-printer')
                ->action(function (Model $record) {
                    return response()->streamDownload(function () use ($record) {
                        echo FacadePdf::loadHtml(
                            Blade::render('pdf.receipt', ['record' => $record])
                        )->stream();
                    }, 'Recibo de ' . $record->type . ' a ' . $record->Beneficiary->name . '.pdf');
                })
        ];
    }
}
