<?php

namespace App\Filament\Resources\BeneficiaryResource\Pages;

use App\Exports\BeneficiaryExport;
use App\Exports\CustomBeneficiaryExport;
use App\Filament\Resources\BeneficiaryResource;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\ListRecords;
use pxlrbt\FilamentExcel\Actions\Pages\ExportAction;

class ListBeneficiaries extends ListRecords
{
    protected static string $resource = BeneficiaryResource::class;

    protected function getHeaderActions(): array
    {
        return [

            Action::make('export')
                ->label('Listado de Usuarios')
                ->color('info')
                ->icon('tabler-file-type-xls')
                ->url('beneficiaries/export/beneficiaries'),
            Actions\CreateAction::make(),
        ];
    }
}
