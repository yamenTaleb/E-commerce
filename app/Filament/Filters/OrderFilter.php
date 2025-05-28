<?php

namespace App\Filament\Filters;

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
                   'paid' => 'Paid',
                   'unpaid' => 'Unpaid',
                   'cancelled' => 'Cancelled',
                   'shipped' => 'Shipped',
                   'pending' => 'Pending',
                   'processing' => 'Processing',
                   'refunded' => 'Refunded',
                   'delivered' => 'Delivered',
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
