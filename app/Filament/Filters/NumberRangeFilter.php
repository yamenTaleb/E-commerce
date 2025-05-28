<?php

namespace App\Filament\Filters;

use Filament\Forms\Components\TextInput;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

class NumberRangeFilter
{
    public static function makeFilter(string $name, ?string $column = null, ?string $label = null): Filter
    {
        $column = $column ?? $name;
        $label = $label ?? ucfirst(str_replace('_', ' ', $name));

        return Filter::make($name)
            ->form([
                TextInput::make('from')
                    ->numeric()
                    ->step(1)
                    ->label("From {$label}"),
                TextInput::make('to')
                    ->numeric()
                    ->step(1)
                    ->label("To {$label}")
                    ->gt('from'),
            ])
            ->query(function (Builder $query, array $data) use ($column): Builder {
                return $query
                    ->when(
                        $data['from'] ?? null,
                        fn (Builder $query, $value) => $query->where($column, '>=', $value)
                    )
                    ->when(
                        $data['to'] ?? null,
                        fn (Builder $query, $value) => $query->where($column, '<=', $value)
                    );
            })
            ->label($label);
    }
}
