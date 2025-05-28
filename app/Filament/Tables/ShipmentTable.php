<?php

namespace App\Filament\Tables;

use App\Enums\OrderStatusEnum;
use App\Models\shipment;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;

class ShipmentTable
{
    public static function getColumns(): array
    {
        return [
            TextColumn::make('id')
                ->label('ID')
                ->sortable()
                ->searchable(),

            TextColumn::make('order_id')
                ->label('Order Number')
                ->sortable()
                ->searchable()
                ->url(fn ($record) => route('filament.admin.resources.orders.edit', $record->order_id)),

            TextColumn::make('order.user.name')
                ->label('Customer Name')
                ->searchable()
                ->sortable()
                ->weight('medium')
                ->url(fn ($record) => route('filament.admin.resources.users.view', $record->order->user_id)),

            TextColumn::make('shipment_date')
                ->label('Shipment Date')
                ->dateTime('M d, Y')
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true)
                ->color('gray')
                ->description(fn (shipment $record) => $record->shipment_date->diffForHumans()),

            TextColumn::make('delivery_date')
                ->label('Delivery Date')
                ->dateTime('M d, Y')
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true)
                ->color('gray')
                ->description(fn (shipment $record) => $record->delivery_date->diffForHumans()),

            IconColumn::make('shipment_status')
                ->label('Status')
                ->icon(fn (string $state): string => match ($state) {
                    OrderStatusEnum::CANCELED->value => 'heroicon-o-x-circle',
                    OrderStatusEnum::SHIPPED->value => 'heroicon-o-truck',
                    OrderStatusEnum::PROCESSING->value => 'heroicon-o-arrow-path',
                    OrderStatusEnum::DELIVERED->value => 'heroicon-o-check-circle',
                    default => 'heroicon-o-question-mark-circle',
                })
                ->color(fn (string $state): string => match ($state) {
                    'pending' => 'warning',
                    'shipped' => 'info',
                    'in_transit' => 'primary',
                    'delivered' => 'success',
                    default => 'gray',
                })
                ->sortable()
                ->searchable(),
        ];
    }
}
