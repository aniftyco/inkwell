<?php

namespace App\Filament\Resources\PostResource\Pages;

use App\Enums\PostStatus;
use App\Filament\Resources\PostResource;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Enums\MaxWidth;
use Illuminate\Database\Eloquent\Builder;

class ListPosts extends ListRecords
{
    protected static string $resource = PostResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->slideOver()->modalWidth(MaxWidth::Full),
        ];
    }

    public function getDefaultActiveTab(): string|int|null
    {
        return PostStatus::PUBLISHED->getLabel();
    }

    public function getTabs(): array
    {
        return [
            PostStatus::PUBLISHED->getLabel() => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', PostStatus::PUBLISHED)),

            PostStatus::DRAFT->getLabel() => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', PostStatus::DRAFT)),

            PostStatus::SCHEDULED->getLabel() => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', PostStatus::SCHEDULED)),

        ];
    }
}
