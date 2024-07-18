<?php

namespace NiftyCo\Inkwell\Resources;

use App\{Enums, Models};
use Filament\{Forms, Tables, Resources, Support, Forms\Components, Tables\Columns, Support\Colors};
use NiftyCo\Inkwell\Pages;
use Illuminate\Support\Str;

class Posts extends Resources\Resource
{
    protected static ?string $model = Models\Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $recordTitleAttribute = 'title';


    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Components\Section::make()->schema([
                    Components\TextInput::make('title')
                        ->columnSpanFull()
                        ->required()
                        ->live(debounce: 500)
                        ->afterStateUpdated(function (Forms\Get $get, Forms\Set $set, ?string $old, ?string $state) {
                            if (($get('slug') ?? '') !== Str::slug($old)) {
                                return;
                            }

                            $set('slug', Str::slug($state));
                        }),
                    Components\MarkdownEditor::make('body')
                        ->required()
                        ->columnSpanFull(),
                ])->columns([
                            'sm' => 2,
                        ])
                    ->columnSpan(2),
                // Sidebar
                Components\Section::make()->schema([
                    Components\TextInput::make('slug')
                        ->required()
                        ->unique(Models\Post::class, 'slug', fn ($record) => $record),
                    Components\Textarea::make('excerpt')
                        ->required()
                        ->autosize()
                        ->columnSpanFull(),
                    Components\FileUpload::make('og_image')
                        ->image()
                        ->maxSize(2048)
                        ->imageResizeMode('cover')
                        ->imageCropAspectRatio('1.91:1')
                        ->imageResizeTargetWidth(1200)
                        ->imageResizeTargetHeight(628)
                        ->disk('public')
                        ->directory('posts'),
                    Components\Grid::make()->schema([
                        Components\Select::make('status')
                            ->native(false)
                            ->options(Enums\PostStatus::class)
                            ->default(Enums\PostStatus::DRAFT)
                            ->required()
                            ->columnSpan(1),
                        Components\Select::make('access')
                            ->native(false)
                            ->options(Enums\PostAccess::class)
                            ->default(Enums\PostAccess::PUBLIC )
                            ->required()
                            ->columnSpan(1),
                    ]),
                    Components\Select::make('user_id')
                        ->label('Author')
                        ->relationship(name: 'user', titleAttribute: 'name')
                        ->native(false)
                        ->required()
                        ->preload()
                        ->default(fn () => auth()->id())
                        ->columnSpan(1),
                    Components\DateTimePicker::make('published_at')
                        ->native(false)
                        ->seconds(false)
                        ->closeOnDateSelection()
                        ->default(fn () => now()),
                ])->columnSpan(1)
            ])->columns(3);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->searchable(false)
            ->selectable(false)
            ->emptyStateIcon(static::$navigationIcon)
            ->emptyStateDescription('Once you write your first post, it will appear here.')
            ->columns([
                Columns\TextColumn::make('title')->icon('heroicon-s-document'),
                Columns\TextColumn::make('access')
                    ->badge()
                    ->color(fn (Models\Post $post) => match ($post->access) {
                        Enums\PostAccess::PUBLIC => Colors\Color::Green,
                        Enums\PostAccess::MEMBERS_ONLY => Colors\Color::Pink,
                    }),
                Columns\TextColumn::make('user.name')
                    ->label('Author')
                    ->sortable(),
                Columns\TextColumn::make('published_at')
                    ->dateTime()
                    ->sortable()
                    ->formatStateUsing(fn (Models\Post $post) => $post->published_at->format('j M Y, g:i A')),
            ])
            ->defaultSort('published_at', 'desc')
            ->actions([
                Tables\Actions\EditAction::make()->slideOver()->modalWidth(Support\Enums\MaxWidth::Full),
                Tables\Actions\Action::make('delete')
                    ->requiresConfirmation()
                    ->color(Colors\Color::Red)
                    ->icon('heroicon-o-trash')
                    ->action(fn (Models\Post $post) => $post->delete()),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\Posts::route('/'),
        ];
    }
}
