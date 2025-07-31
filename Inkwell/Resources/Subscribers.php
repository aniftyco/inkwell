<?php

namespace Inkwell\Resources;

use App\Models\Subscriber;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\MaxWidth;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Inkwell\Pages\Subscribers as SubscribersPage;

class Subscribers extends Resource
{
    protected static ?string $model = Subscriber::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $recordTitleAttribute = 'email';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255),
                Hidden::make('confirmed_at')->default(fn () => now()),
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->searchable(false)
            ->selectable(false)
            ->emptyStateIcon(static::$navigationIcon)
            ->emptyStateDescription('Your subscribers will appear here.')
            ->columns([
                TextColumn::make('email')
                    ->icon('heroicon-s-envelope'),
                TextColumn::make('created_at')
                    ->label('Subscribed at')
                    ->dateTime()
                    ->formatStateUsing(fn (Subscriber $subscriber) => $subscriber->created_at->format('j M Y, g:i A'))
                    ->sortable(),
                TextColumn::make('confirmed_at')
                    ->dateTime()
                    ->formatStateUsing(fn (Subscriber $subscriber) => $subscriber->confirmed_at->format('j M Y, g:i A'))
                    ->sortable(),
            ])
            ->actions([
                EditAction::make()->slideOver()->modalWidth(MaxWidth::Large),
                Action::make('delete')
                    ->requiresConfirmation()
                    ->color(Color::Red)
                    ->icon('heroicon-o-trash')
                    ->action(fn (Subscriber $subscriber) => $subscriber->delete()),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => SubscribersPage::route('/'),
        ];
    }
}
