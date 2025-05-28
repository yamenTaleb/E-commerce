<?php

namespace App\Filament\Tables;

use App\Models\User;
use Filament\Tables\Columns\TextColumn;

class CategoryTable
{
    public static function getColumns(): array
    {
        return [
            TextColumn::make('name')
                ->sortable()
                ->searchable(),
            TextColumn::make('slug')
                ->toggleable(isToggledHiddenByDefault: true)
                ->searchable(),
            TextColumn::make('description')
                ->toggleable(isToggledHiddenByDefault: true)
                ->wrap()
                ->fontFamily('monospace'),

            TextColumn::make('created_at')
                ->label('Added On')
                ->dateTime('M d, Y')
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true)
                ->color('gray')
                ->description(fn ($record) => $record->created_at->diffForHumans()),

            TextColumn::make('parentCategory.name')
                ->searchable()
                ->sortable()
                ->default('-')
                ->url(fn ($record) => $record->parentCategory ? route('filament.admin.resources.categories.view', $record->parentCategory->slug) : null)
        ];
    }
}
