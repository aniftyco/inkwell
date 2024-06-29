<?php

namespace NiftyCo\Inkwell\Pages;

use NiftyCo\Inkwell\Resources;
use Filament\{Actions, Resources\Pages, Resources\Components, Support\Enums};
use Illuminate\Database\Eloquent\Builder;

class Subscribers extends Pages\ListRecords
{
    protected static string $resource = Resources\Subscribers::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->modalWidth(Enums\MaxWidth::Large),
        ];
    }

    public function getDefaultActiveTab(): string|int|null
    {
        return 'confirmed';
    }

    public function getTabs(): array
    {
        return [
            'confirmed' => Components\Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->whereNotNull('confirmed_at')),

            'unconfirmed' => Components\Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->whereNull('confirmed_at')),

        ];
    }
}
