<?php

namespace App\Filament\Resources\PaisajeResource\Pages;

use App\Filament\Resources\PaisajeResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManagePaisajes extends ManageRecords
{
    protected static string $resource = PaisajeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
