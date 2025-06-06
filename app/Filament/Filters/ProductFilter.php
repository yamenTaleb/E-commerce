<?php

namespace App\Filament\Filters;

use Filament\Tables\Filters\SelectFilter;

class ProductFilter
{
    public static function getFilters(): array
    {
       return [
           DateRangeFilter::make('created_at'),
           NumberRangeFilter::makeFilter('price', 'price', 'Price'),
           NumberRangeFilter::makeFilter('stock_quantity', 'stock_quantity', 'Stock Quantity')
       ];
    }
}
