<?php

namespace App\Filament\Tables;

use Filament\Tables\Columns\TextColumn;

class IssueTable
{
    public static function getColumns(): array
    {
        return [
            TextColumn::make('product.name')
                ->url(fn ($record) => route('filament.admin.resources.products.view', $record->product->slug)),


            TextColumn::make('customer.name')
                ->label('Customer Name')
                ->searchable()
                ->sortable()
                ->weight('medium')
                ->description(fn ($record) => \Illuminate\Support\Str::limit($record->subject, 50))
                ->wrap()
                ->url(fn ($record) => route('filament.admin.resources.users.view', $record->customer->id)),

            TextColumn::make('description')
                ->toggleable(isToggledHiddenByDefault: true)
                ->wrap()
                ->limit(),

            TextColumn::make('status')
                ->badge()
                ->color(fn($record) => match ($record->status) {
                    'pending' => 'warning',
                    'considered' => 'info',
                    'solved' => 'success',
                }),

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
