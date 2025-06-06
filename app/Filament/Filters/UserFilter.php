<?php

namespace App\Filament\Filters;

use App\Models\User;
use Filament\Tables\Filters\SelectFilter;
use App\Filament\Filters\NumberRangeFilter;
use Illuminate\Support\Facades\Cache;

class UserFilter
{
    public static function getFilters(): array
    {
        // Fetch all users with names, roles, and emails in a single query
        $users = Cache::remember('user_filter_options', 60 * 60, function () { // Cache for 1 hour
            return User::select(['name', 'email'])->get();
        });

        $nameOptions = $users->pluck('name', 'name')->toArray();
        $emailOptions = $users->pluck('email', 'email')->toArray();

        return [
            SelectFilter::make('name')
                ->label('Name')
                ->options($nameOptions)
                ->searchable()
                ->preload()
                ->multiple(),
            SelectFilter::make('role')
                ->label('Role')
                ->options([
                    'admin' => 'Admin',
                    'user' => 'User',
                ])
                ->searchable()
                ->preload()
                ->multiple(),
            SelectFilter::make('email')
                ->label('Email')
                ->options($emailOptions)
                ->searchable()
                ->preload()
                ->multiple(),

            DateRangeFilter::make('created_at')
        ];
    }
}
