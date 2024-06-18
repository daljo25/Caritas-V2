<?php

namespace App\Filament\Resources\DerivationResource\Pages;

use App\Filament\Resources\DerivationResource;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Blade;

class EditDerivation extends EditRecord
{
    protected static string $resource = DerivationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('pdf')
                ->label('Hoja de Derivación')
                ->color('success')
                ->icon('tabler-printer')
                ->action(function (Model $record) {
                    return response()->streamDownload(function () use ($record) {
                        echo FacadePdf::loadHtml(
                            Blade::render('pdf.derivation', ['record' => $record])
                        )->stream();
                    }, 'Hoja de Derivación.pdf');
                })
        ];
    }
}
