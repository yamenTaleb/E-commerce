<?php

namespace App\Filament\Tables;

use App\Enums\OrderStatusEnum;
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
                    OrderStatusEnum::SHIPPED->value => OrderStatusEnum::SHIPPED->color(),
                    OrderStatusEnum::DELIVERED->value, OrderStatusEnum::PAID->value => OrderStatusEnum::PAID->color(),
                    OrderStatusEnum::CANCELED->value, OrderStatusEnum::REFUNDED->value => OrderStatusEnum::REFUNDED->color(),
                    OrderStatusEnum::UNPAID->value, OrderStatusEnum::PROCESSING->value, OrderStatusEnum::PENDING => OrderStatusEnum::UNPAID->color(),
                    default => 'gray'
                }),

            TextColumn::make('total_price')
                ->label('Total')
                ->money('USD')
                ->sortable()
                ->toggleable()
                ->color('gray')
        ];
    }
}
