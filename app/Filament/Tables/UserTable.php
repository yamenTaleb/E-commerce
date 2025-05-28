<?php

namespace App\Filament\Tables;

use App\Models\User;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class UserTable
{
    public static function getColumns(): array
    {
        return [
            TextColumn::make('name')
                ->sortable()
                ->searchable(),
            TextColumn::make('email')
                ->url(fn (User $record): string => 'mailto:' . $record->email)
                ->searchable()
                ->openUrlInNewTab(),
            TextColumn::make('email_verified_at')
                ->dateTime()
                ->label('Email Verified At')
                ->toggleable(isToggledHiddenByDefault: true),
            TextColumn::make('role')
                ->badge()
                ->color(fn (User $record) => match ($record->role) {
                    'admin' => 'danger',
                    default => 'warning',
                })
                ->label('Role')
                ->searchable()
                ->toggleable(),

            TextColumn::make('created_at')
                ->label('Added On')
                ->dateTime('M d, Y')
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true)
                ->color('gray')
                ->description(fn ($record) => $record->created_at->diffForHumans()),

            TextColumn::make('updated_at')
                ->label('Updated On')
                ->dateTime('M d, Y')
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true)
                ->color('gray')
                ->description(fn ($record) => $record->created_at->diffForHumans()),

            TextColumn::make('address')
                ->label('Address')
                ->toggleable(),
        ];
    }
}
