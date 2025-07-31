<?php

namespace Inkwell\Pages;

use Filament\Pages\Actions\CreateAction;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Enums\MaxWidth;
use Illuminate\Database\Eloquent\Builder;
use Inkwell\Resources\Subscribers as SubscribersResource;

class Subscribers extends ListRecords
{
    protected static string $resource = SubscribersResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->modalWidth(MaxWidth::Large),
        ];
    }

    public function getDefaultActiveTab(): string|int|null
    {
        return 'confirmed';
    }

    public function getTabs(): array
    {
        return [
            'confirmed' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->whereNotNull('confirmed_at')),

            'unconfirmed' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->whereNull('confirmed_at')),

        ];
    }
}
