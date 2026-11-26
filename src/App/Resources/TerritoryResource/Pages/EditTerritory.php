<?php

declare(strict_types=1);

namespace Liberu\CRM\TerritoriesAndOwnership\Filament\App\Resources\TerritoryResource\Pages;

use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Liberu\CRM\TerritoriesAndOwnership\Filament\App\Resources\TerritoryResource;

class EditTerritory extends EditRecord
{
    protected static string $resource = TerritoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
