<?php

namespace App\Filament\Tables;

use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\Summarizers\Average;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ProductTable
{
    public static function getColumns(): array
    {
        return [
            ImageColumn::make('productImages.name')
                ->label('')
                ->circular()
                ->stacked()
                ->limit(3)
                ->limitedRemainingText(isSeparate: true)
                ->toggleable()
                ->searchable(),

            TextColumn::make('name')
                ->label('Product Name')
                ->searchable()
                ->sortable()
                ->weight('medium')
                ->description(fn ($record) => \Illuminate\Support\Str::limit($record->description, 50))
                ->wrap(),

            TextColumn::make('price')
                ->label('Price')
                ->money('USD')
                ->sortable()
                ->color('success')
                ->weight('bold')
                ->alignEnd()
                ->description('+ tax if applicable'),

            TextColumn::make('stock_quantity')
                ->label('In Stock')
                ->sortable()
                ->alignCenter()
                ->color(fn ($record) => $record->stock_quantity > 10 ? 'success' : 'danger')
                ->icon(fn ($record) => $record->stock_quantity > 10 ? 'heroicon-o-check-circle' : 'heroicon-o-x-circle')
                ->badge()
                ->formatStateUsing(fn ($state) => $state . ' units'),

            TextColumn::make('created_at')
                ->label('Added On')
                ->dateTime('M d, Y')
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true)
                ->color('gray')
                ->description(fn ($record) => $record->created_at->diffForHumans()),

            TextColumn::make('rating')
                ->label('Rating')
                ->sortable()
                ->alignCenter()
                ->badge()
                ->toggleable(isToggledHiddenByDefault: true)
                ->color(fn ($record) => $record->rating > 3 ? 'success' : 'danger')
                ->icon(fn ($record) => $record->rating > 3 ? 'heroicon-o-star' : 'heroicon-o-star')
                ->summarize(Average::make()),
        ];
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns(self::getColumns())
            ->defaultSort('created_at', 'desc');
    }
}
