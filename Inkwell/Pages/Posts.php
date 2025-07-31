<?php

namespace Inkwell\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Enums\MaxWidth;
use Illuminate\Database\Eloquent\Builder;
use Inkwell\Resources\Posts as PostsResource;

class Posts extends ListRecords
{
    protected static string $resource = PostsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->slideOver()->modalWidth(MaxWidth::Full),
        ];
    }

    public function getDefaultActiveTab(): string|int|null
    {
        return 'all';
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make(),
            'published' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->whereNotNull('published_at')->where('published_at', '<=', now())),

            'drafts' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->whereNull('published_at')),

            'scheduled' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->whereNotNull('published_at')->where('published_at', '>', now())),

        ];
    }
}
