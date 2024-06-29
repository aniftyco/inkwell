<?php

namespace NiftyCo\Inkwell\Resources;

use App\{Models};
use Filament\{Forms, Resources, Tables, Support\Enums, Support\Colors, Tables\Columns, Tables\Actions};
use NiftyCo\Inkwell\Pages;

class Subscribers extends Resources\Resource
{
    protected static ?string $model = Models\Subscriber::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $recordTitleAttribute = 'email';

    public static function form(Forms\Form $form): Forms\Form
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

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->searchable(false)
            ->selectable(false)
            ->emptyStateIcon(static::$navigationIcon)
            ->emptyStateDescription('Your subscribers will appear here.')
            ->columns([
                Columns\TextColumn::make('email')
                    ->icon('heroicon-s-envelope'),
                Columns\TextColumn::make('created_at')
                    ->label('Subscribed at')
                    ->dateTime()
                    ->formatStateUsing(fn (Models\Subscriber $subscriber) => $subscriber->created_at->format('j M Y, g:i A'))
                    ->sortable(),
                Columns\TextColumn::make('confirmed_at')
                    ->dateTime()
                    ->formatStateUsing(fn (Models\Subscriber $subscriber) => $subscriber->confirmed_at->format('j M Y, g:i A'))
                    ->sortable(),
            ])
            ->actions([
                Actions\EditAction::make()->slideOver()->modalWidth(Enums\MaxWidth::Large),
                Actions\Action::make('delete')
                    ->requiresConfirmation()
                    ->color(Colors\Color::Red)
                    ->icon('heroicon-o-trash')
                    ->action(fn (Models\Subscriber $subscriber) => $subscriber->delete()),
            ]);
    }


    public static function getPages(): array
    {
        return [
            'index' => Pages\Subscribers::route('/'),
        ];
    }
}
