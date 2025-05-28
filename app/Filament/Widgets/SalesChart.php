<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Filament\Widgets\ChartWidget;

class SalesChart extends ChartWidget
{
    protected static ?string $heading = 'Monthly Sales';
    protected static ?int $sort = 2;
    protected static ?string $pollingInterval = '60s';
    protected static bool $isLazy = true;
    protected int | string | array $columnSpan = [
        'md' => 1,
        'xl' => 1,
    ];
    
    protected function getColumns(): int
    {
        return 1;
    }

    protected function getData(): array
    {
        // Get monthly sales data for the current year
        $salesData = DB::table('orders')
            ->select(
                DB::raw('DATE_FORMAT(order_date, "%Y-%m") as month'),
                DB::raw('SUM(total) as total')
            )
            ->where('status', ['paid', 'shipped', 'delivered'])
            ->whereYear('order_date', now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month');

        // Generate all months of the year with 0 as default
        $months = collect(range(1, 12))->mapWithKeys(function ($month) {
            $date = now()->setMonth($month)->startOfMonth();
            return [$date->format('Y-m') => 0];
        });

        // Merge actual data with default months
        $chartData = $months->merge($salesData);

        return [
            'datasets' => [
                [
                    'label' => 'Monthly Sales',
                    'data' => $chartData->values()->toArray(),
                    'borderColor' => 'rgb(59, 130, 246)',
                    'backgroundColor' => 'rgba(59, 130, 246, 0.2)',
                    'fill' => true,
                    'tension' => 0.4,
                ],
            ],
            'labels' => $chartData->keys()->map(fn ($month) => now()->parse($month)->format('M'))->toArray(),
        ];
    }


    protected function getType(): string
    {
        return 'line';
    }
}
