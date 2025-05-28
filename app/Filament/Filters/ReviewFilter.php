<?php

namespace App\Filament\Filters;

class ReviewFilter
{
    public static function getFilters(): array
    {
       return [
           DateRangeFilter::make('created_at'),
           NumberRangeFilter::makeFilter('rating', 'rating', 'Rating'),
       ];
    }
}
