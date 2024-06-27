<?php

namespace App\Filament\Resources;

use App\Enums\PostAccess;
use App\Enums\PostStatus;
use App\Filament\Resources\PostResource\Pages;
use App\Filament\Resources\PostResource\RelationManagers;
use App\Models\Post;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()->schema([

                    Forms\Components\TextInput::make('title')
                        ->columnSpanFull()
                        ->required()
                        ->live(debounce: 500)
                        ->afterStateUpdated(function (Get $get, Set $set, ?string $old, ?string $state) {
                            if (($get('slug') ?? '') !== Str::slug($old)) {
                                return;
                            }

                            $set('slug', Str::slug($state));
                        }),
                    Forms\Components\MarkdownEditor::make('body')
                        ->required()
                        ->columnSpanFull(),
                ])->columns([
                            'sm' => 2,
                        ])
                    ->columnSpan(2),
                // Sidebar
                Forms\Components\Section::make()->schema([
                    Forms\Components\TextInput::make('slug')
                        ->required()
                        ->unique(Post::class, 'slug', fn ($record) => $record),
                    Forms\Components\Textarea::make('excerpt')
                        ->required()
                        ->autosize()
                        ->columnSpanFull(),
                    Forms\Components\Grid::make()->schema([
                        Forms\Components\Select::make('status')
                            ->native(false)
                            ->options(PostStatus::class)
                            ->default(PostStatus::DRAFT)
                            ->required()
                            ->columnSpan(1),
                        Forms\Components\Select::make('access')
                            ->native(false)
                            ->options(PostAccess::class)
                            ->default(PostAccess::PUBLIC )
                            ->required()
                            ->columnSpan(1),
                    ]),
                    Forms\Components\Select::make('user_id')
                        ->label('Author')
                        ->relationship(name: 'user', titleAttribute: 'name')
                        ->native(false)
                        ->required()
                        ->preload()
                        ->searchable()
                        ->default(fn () => auth()->id())
                        ->columnSpan(1),
                    Forms\Components\DateTimePicker::make('published_at')
                        ->native(false)
                        ->seconds(false)
                        ->closeOnDateSelection(),
                ])->columnSpan(1)
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->searchable(),
                Tables\Columns\TextColumn::make('access')
                    ->searchable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Author')
                    ->sortable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('published_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }
}
