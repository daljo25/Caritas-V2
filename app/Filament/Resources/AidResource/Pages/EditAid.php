<?php

namespace App\Filament\Resources\AidResource\Pages;

use App\Filament\Resources\AidResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAid extends EditRecord
{
    protected static string $resource = AidResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
