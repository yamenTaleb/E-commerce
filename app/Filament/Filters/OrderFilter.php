<?php

namespace App\Filament\Filters;

use App\Enums\OrderStatusEnum;
use App\Models\Order;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Cache;

class OrderFilter
{
    public static function getFilters(): array
    {
       return [
           SelectFilter::make('status')
               ->label('Status')
               ->options([
                   'paid' => OrderStatusEnum::PAID->label(),
                   'unpaid' => OrderStatusEnum::UNPAID->label(),
                   'cancelled' => OrderStatusEnum::CANCELED->label(),
                   'shipped' => OrderStatusEnum::SHIPPED->label(),
                   'pending' => OrderStatusEnum::PENDING->label(),
                   'refunded' => OrderStatusEnum::REFUNDED->label(),
                   'delivered' => OrderStatusEnum::DELIVERED->label(),
                   'processing' => OrderStatusEnum::PROCESSING->label(),
               ])
               ->searchable()
               ->preload()
               ->multiple(),

           DateRangeFilter::make('order_date')
               ->label('Date')
               ->column('order_date'),
       ];
    }
}
