<?php

namespace App\Filament\Filters;

use Filament\Tables\Filters\SelectFilter;

class IssueFilter
{
    public static function getFilters(): array
    {
       return [
           DateRangeFilter::make('created_at')
               ->column('created_at')
       ];
    }
}
