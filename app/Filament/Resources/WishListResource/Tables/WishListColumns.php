<?php

namespace App\Filament\Resources\WishListResource\Tables;

use Filament\Tables;
use Filament\Tables\Columns\TextColumn;

class WishListColumns
{
    public static function getColumns(): array
    {
        return [
            TextColumn::make('id')
                ->sortable()
                ->searchable()
                ->label('#'),

            TextColumn::make('user.name')
                ->sortable()
                ->searchable()
                ->label('Customer Name')
                ->url(fn ($record) => route('filament.admin.resources.users.view', $record->user_id)),

            TextColumn::make('product.name')
                ->sortable()
                ->searchable()
                ->label('Product Name')
                ->url(fn ($record) => route('filament.admin.resources.products.view', $record->product->slug)),


            TextColumn::make('comment')
                ->wrap()
                ->weight('medium')
                ->fontFamily('monospace')
                ->color('gray')
                ->toggleable()
                ->searchable()
                ->label('Comment')
                ->limit(50),


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
