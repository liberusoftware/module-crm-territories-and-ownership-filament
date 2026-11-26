<?php

declare(strict_types=1);

namespace Liberu\CRM\TerritoriesAndOwnership\Filament\App\Resources;

use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Facades\Filament;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Liberu\CRM\Core\Filament\Concerns\EnforcesResourcePermissions;
use Liberu\CRM\TerritoriesAndOwnership\Filament\App\Resources\TerritoryResource\Pages\CreateTerritory;
use Liberu\CRM\TerritoriesAndOwnership\Filament\App\Resources\TerritoryResource\Pages\EditTerritory;
use Liberu\CRM\TerritoriesAndOwnership\Filament\App\Resources\TerritoryResource\Pages\ListTerritories;
use Liberu\CRM\TerritoriesAndOwnership\Filament\App\Resources\TerritoryResource\Pages\ViewTerritory;
use Liberu\CRM\TerritoriesAndOwnership\Models\Territory;
use Liberu\Foundation\Organizations\Models\Team;

class TerritoryResource extends Resource
{
    use EnforcesResourcePermissions;

    protected static ?string $model = Territory::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-map';

    protected static string|\UnitEnum|null $navigationGroup = 'Team';

    protected static ?string $navigationLabel = 'Territories';

    protected static ?string $slug = 'territories';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('name')->required()->maxLength(255),
            Select::make('users')
                ->label('Members')
                ->multiple()
                ->preload()
                ->relationship('users', 'name', fn (Builder $query): Builder => $query->whereIn('users.id', self::teamMemberIds())),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->searchable(),
                TextColumn::make('users_count')->counts('users')->label('Members'),
                TextColumn::make('updated_at')->dateTime()->sortable(),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                DeleteBulkAction::make(),
            ])
            ->defaultSort('name');
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTerritories::route('/'),
            'create' => CreateTerritory::route('/create'),
            'view' => ViewTerritory::route('/{record}'),
            'edit' => EditTerritory::route('/{record}/edit'),
        ];
    }

    /**
     * @return array<int, int>
     */
    private static function teamMemberIds(): array
    {
        $tenant = Filament::getTenant();

        return $tenant instanceof Team ? $tenant->allUsers()->pluck('id')->all() : [];
    }
}
