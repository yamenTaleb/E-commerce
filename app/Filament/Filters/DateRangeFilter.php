<?php

namespace App\Filament\Filters;

use Filament\Forms\Components\DatePicker;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

class DateRangeFilter extends Filter
{
    protected string $column = 'created_at';
    protected string|\Closure|null $label = 'Created At';

    public static function make(?string $name = null, ?string $column = null, ?string $label = null): static
    {
        $filter = parent::make($name);

        if ($column !== null) {
            $filter->column($column);
        }

        if ($label !== null) {
            $filter->label($label);
        }

        return $filter;
    }

    public function column(string $column): static
    {
        $this->column = $column;
        return $this;
    }

    protected function setup(): void
    {
        $this->form([
            DatePicker::make('_from')
                ->label('From Date'),
            DatePicker::make('_until')
                ->label('To Date'),
        ]);
    }

    public function apply(Builder $query, array $data = []): Builder
    {
        return $query
            ->when(
                $data['_from'] ?? null,
                fn (Builder $query, $date) => $query->whereDate($this->column, '>=', $date)
            )
            ->when(
                $data['_until'] ?? null,
                fn (Builder $query, $date) => $query->whereDate($this->column, '<=', $date)
            );
    }
}
