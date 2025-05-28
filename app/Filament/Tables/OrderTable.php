<?php

namespace App\Filament\Tables;

use Filament\Tables\Columns\TextColumn;
use function Livewire\wrap;

class OrderTable
{
    public static function getColumns(): array
    {
        return [
            TextColumn::make('session_id')
                ->wrap(),
             TextColumn::make('order_date')
                ->label('Date')
                ->dateTime('M d, Y')
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true)
                ->color('gray'),

            TextColumn::make('user.name')
                ->label('Customer Name')
                ->searchable()
                ->sortable()
                ->weight('medium')
                ->url(fn ($record) => route('filament.admin.resources.users.view', $record->user->id)),

            TextColumn::make('status')
                ->badge()
                ->color(fn ($record) => match ($record->status) {
                    'canceled' => 'danger',
                    'paid', 'shipped', 'delivered' => 'success',
                    'unpaid', 'refunded', 'pending' => 'warning',
                    'processing' => 'info'
                }),

            TextColumn::make('total')
                ->label('Total')
                ->money('USD')
                ->sortable()
                ->toggleable()
                ->color('gray')
        ];
    }
}
