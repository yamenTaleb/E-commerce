<?php

namespace App\Filament\Tables;

use Filament\Tables\Columns\Summarizers\Average;
use Filament\Tables\Columns\TextColumn;

class ReviewTable
{
    public static function getColumns(): array
    {
        return [
            TextColumn::make('rating')
                ->label('Rating')
                ->sortable()
                ->alignCenter()
                ->badge()
                ->toggleable()
                ->color(fn ($record) => $record->rating > 3 ? 'success' : 'danger')
                ->icon(fn ($record) => $record->rating > 3 ? 'heroicon-o-star' : 'heroicon-o-star')
                ->summarize(Average::make()),

            TextColumn::make('created_at')
                ->label('Added On')
                ->dateTime('M d, Y')
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true)
                ->color('gray')
                ->description(fn ($record) => $record->created_at->diffForHumans()),

        ];
    }
}
