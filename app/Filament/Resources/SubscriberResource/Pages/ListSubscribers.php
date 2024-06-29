<?php

namespace App\Filament\Resources\SubscriberResource\Pages;

use App\Filament\Resources\SubscriberResource;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Enums\MaxWidth;
use Illuminate\Database\Eloquent\Builder;

class ListSubscribers extends ListRecords
{
    protected static string $resource = SubscriberResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->modalWidth(MaxWidth::Large),
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
