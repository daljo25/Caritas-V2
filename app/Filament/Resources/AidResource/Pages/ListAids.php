<?php

namespace App\Filament\Resources\AidResource\Pages;

use App\Filament\Resources\AidResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Blade;
use App\Models\Aid;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Barryvdh\DomPDF\PDF;

class ListAids extends ListRecords
{
    protected static string $resource = AidResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('COVIRAN')
                ->label('COVIRAN')
                ->color('success')
                ->icon('tabler-printer')
                ->action(function (Aid $aid) {
                    return response()->streamDownload(function () use ($aid) {
                        echo FacadePdf::loadHtml(
                            Blade::render('pdf.coviran', ['record' => $aid])
                            )->stream();
                        }, 'COVIRAN ' . date('m-Y') .'.pdf');
                    }),
            Actions\CreateAction::make(),
        ];
    }
}
