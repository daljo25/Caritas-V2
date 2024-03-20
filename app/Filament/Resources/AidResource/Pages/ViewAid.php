<?php

namespace App\Filament\Resources\AidResource\Pages;

use App\Filament\Resources\AidResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewAid extends ViewRecord
{
    protected static string $resource = AidResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
