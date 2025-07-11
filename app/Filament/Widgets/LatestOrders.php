<?php

namespace App\Filament\Widgets;

use App\Enums\OrderStatusEnum;
use App\Models\Order;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class LatestOrders extends BaseWidget
{
    protected static ?string $heading = 'Latest Orders';
    protected static ?int $sort = 3;
    protected int|string|array $columnSpan = 'full';
    protected static ?string $pollingInterval = '30s';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Order::query()
                    ->with(['user'])
                    ->orderBy('order_date', 'desc')
                    ->limit(5)
            )
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('Order ID')
                    ->searchable(),

                Tables\Columns\TextColumn::make('user.name')
                    ->label('Customer')
                    ->searchable()
                    ->url(fn (Order $record): string => route('filament.admin.resources.users.view', $record->user_id)),

                Tables\Columns\TextColumn::make('order_date')
                    ->dateTime()
                    ->sortable(),

                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        OrderStatusEnum::SHIPPED->value => OrderStatusEnum::SHIPPED->color(),
                        OrderStatusEnum::DELIVERED->value, OrderStatusEnum::PAID->value => OrderStatusEnum::PAID->color(),
                        OrderStatusEnum::CANCELED->value, OrderStatusEnum::REFUNDED->value => OrderStatusEnum::REFUNDED->color(),
                        OrderStatusEnum::UNPAID->value, OrderStatusEnum::PROCESSING->value, OrderStatusEnum::PENDING => OrderStatusEnum::UNPAID->color(),
                        default => 'gray'

                    }),

                Tables\Columns\TextColumn::make('total_price')
                    ->label('Total')
            ])
            ->actions([
                Tables\Actions\Action::make('view')
                    ->url(fn (Order $record): string => route('filament.admin.resources.orders.view', $record))
                    ->color('gray')
                    ->icon('heroicon-o-eye'),
            ]);
    }
}
