<?php

namespace App\Filament\Resources\PredialAcuerdoResource\Pages;

use App\Filament\Resources\PredialAcuerdoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPredialAcuerdo extends EditRecord
{
    protected static string $resource = PredialAcuerdoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
