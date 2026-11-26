<?php

declare(strict_types=1);

namespace Liberu\CRM\TerritoriesAndOwnership\Filament\App\Resources\TerritoryResource\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Liberu\CRM\TerritoriesAndOwnership\Filament\App\Resources\TerritoryResource;

class ListTerritories extends ListRecords
{
    protected static string $resource = TerritoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
