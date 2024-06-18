<?php

namespace App\Filament\Resources\BeneficiaryResource\Pages;

use App\Filament\Resources\BeneficiaryResource;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Blade;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;

class EditBeneficiary extends EditRecord
{
    protected static string $resource = BeneficiaryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('intervention')
                ->label('Hoja de Intervención')
                ->color('success')
                ->icon('tabler-printer')
                ->action(function (Model $record) {
                    return response()->streamDownload(function () use ($record) {
                        echo FacadePdf::loadHtml(
                            Blade::render('pdf.intervention', ['record' => $record])
                        )->stream();
                    }, 'Hoja de Intervención de ' . $record->name . '.pdf');
                }),
            Action::make('protection')
                ->label('Protección de Datos')
                ->color('info')
                ->icon('tabler-user-shield')
                ->action(function (Model $record) {
                    return response()->streamDownload(function () use ($record) {
                        echo FacadePdf::loadHtml(
                            Blade::render('pdf.data-protection', ['record' => $record])
                        )->stream();
                    }, 'Hoja de Proteccion de Datos de ' . $record->name . '.pdf');
                }),
        ];
    }
}
