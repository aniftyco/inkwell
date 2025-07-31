<?php

namespace Inkwell\Resources;

use App\Models\Post;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\MaxWidth;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Inkwell\Pages\Posts as PostsPage;

class Posts extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()->schema([
                    TextInput::make('title')
                        ->columnSpanFull()
                        ->required()
                        ->live(debounce: 500)
                        ->afterStateUpdated(function (Forms\Get $get, Forms\Set $set, ?string $old, ?string $state) {
                            if (($get('slug') ?? '') !== Str::slug($old)) {
                                return;
                            }

                            $set('slug', Str::slug($state));
                        }),
                    MarkdownEditor::make('body')
                        ->required()
                        ->columnSpanFull(),
                ])->columns([
                    'sm' => 2,
                ])
                    ->columnSpan(2),
                // Sidebar
                Section::make()->schema([
                    TextInput::make('slug')
                        ->required()
                        ->unique(Post::class, 'slug', fn ($record) => $record),
                    Textarea::make('excerpt')
                        ->required()
                        ->autosize()
                        ->columnSpanFull(),
                    Grid::make()->schema([
                        Select::make('user_id')
                            ->label('Author')
                            ->relationship(name: 'author', titleAttribute: 'name')
                            ->native(false)
                            ->required()
                            ->preload()
                            ->default(fn () => auth()->id())
                            ->columnSpan(1),
                        DatePicker::make('published_at')
                            ->native(false)
                            ->seconds(false)
                            ->closeOnDateSelection(),
                    ]),
                ])->columnSpan(1),
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->searchable(false)
            ->selectable(false)
            ->emptyStateIcon(static::$navigationIcon)
            ->emptyStateDescription('Once you write your first post, it will appear here.')
            ->columns([
                TextColumn::make('title')->icon('heroicon-s-document'),
                TextColumn::make('created_at')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(function (Post $post) {
                        if ($post->published_at === null) {
                            return 'Draft';
                        }

                        return now() < $post->published_at ? 'Scheduled' : 'Published';
                    })
                    ->color(function (Post $post) {
                        if ($post->published_at === null) {
                            return Color::Gray;
                        }

                        return now() < $post->published_at ? Color::Yellow : Color::Green;
                    }),
                TextColumn::make('author.name')
                    ->label('Author')
                    ->sortable(),
                TextColumn::make('published_at')
                    ->placeholder('December 10, 1815')
                    ->dateTime()
                    ->sortable()
                    ->formatStateUsing(fn (Post $post) => $post->published_at->format('F j, Y')),
            ])
            ->defaultSort('created_at', 'desc')
            ->actions([
                EditAction::make()->slideOver()->modalWidth(MaxWidth::Full),
                Action::make('delete')
                    ->requiresConfirmation()
                    ->color(Color::Red)
                    ->icon('heroicon-o-trash')
                    ->action(fn (Post $post) => $post->delete()),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => PostsPage::route('/'),
        ];
    }
}
