<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SubscriberResource\Pages;
use App\Models\Subscriber;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\MaxWidth;
use Filament\Tables;
use Filament\Tables\Table;

class SubscriberResource extends Resource
{
    protected static ?string $model = Subscriber::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $recordTitleAttribute = 'email';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255),
                Forms\Components\Hidden::make('confirmed_at')->default(fn () => now()),
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
                Tables\Columns\TextColumn::make('email')
                    ->icon('heroicon-s-envelope'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Subscribed at')
                    ->dateTime()
                    ->formatStateUsing(fn (Subscriber $subscriber) => $subscriber->created_at->format('j M Y, g:i A'))
                    ->sortable(),
                Tables\Columns\TextColumn::make('confirmed_at')
                    ->dateTime()
                    ->formatStateUsing(fn (Subscriber $subscriber) => $subscriber->confirmed_at->format('j M Y, g:i A'))
                    ->sortable(),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->slideOver()->modalWidth(MaxWidth::Large),
                Tables\Actions\Action::make('delete')
                    ->requiresConfirmation()
                    ->color(Color::Red)
                    ->icon('heroicon-o-trash')
                    ->action(fn (Subscriber $subscriber) => $subscriber->delete()),
            ]);
    }


    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSubscribers::route('/'),
        ];
    }
}
