<?php

namespace NiftyCo\Inkwell\Pages;

use App;
use NiftyCo\Inkwell\Resources;
use Filament\{Actions, Support, Resources\Pages, Resources\Components};
use Illuminate\Database\Eloquent\Builder;

class Posts extends Pages\ListRecords
{
    protected static string $resource = Resources\Posts::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->slideOver()->modalWidth(Support\Enums\MaxWidth::Full),
        ];
    }

    public function getDefaultActiveTab(): string|int|null
    {
        return App\Enums\PostStatus::PUBLISHED->getLabel();
    }

    public function getTabs(): array
    {
        return [
            App\Enums\PostStatus::PUBLISHED->getLabel() => Components\Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', App\Enums\PostStatus::PUBLISHED)),

            App\Enums\PostStatus::DRAFT->getLabel() => Components\Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', App\Enums\PostStatus::DRAFT)),

            App\Enums\PostStatus::SCHEDULED->getLabel() => Components\Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', App\Enums\PostStatus::SCHEDULED)),

        ];
    }
}
