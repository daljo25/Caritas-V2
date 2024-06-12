<?php

namespace App\Filament\Resources\DonorResource\Pages;

use App\Filament\Resources\DonorResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDonors extends ListRecords
{
    protected static string $resource = DonorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
