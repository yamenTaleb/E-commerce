<?php

namespace App\Filament\Tables;

use Filament\Tables\Columns\TextColumn;

class CouponTable
{
    public static function getColumns(): array
    {
        return [
            TextColumn::make('code')
                ->sortable()
                ->searchable(),

            TextColumn::make('discount_amount')
                ->label('Discount')
                ->sortable()
                ->alignCenter()
                ->badge()
                ->color(fn ($record) => $record->discount > 12 ? 'danger' : 'success'),

            TextColumn::make('expires_at')
                ->label('Expires')
                ->dateTime('M d, Y')
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true)
                ->color('gray')
                ->description(fn ($record) => $record->expires_at->diffForHumans()),
        ];
    }
}
