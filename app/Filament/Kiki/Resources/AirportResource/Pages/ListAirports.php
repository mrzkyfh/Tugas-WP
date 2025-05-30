<?php

namespace App\Filament\Kiki\Resources\AirportResource\Pages;

use App\Filament\Kiki\Resources\AirportResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAirports extends ListRecords
{
    protected static string $resource = AirportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
