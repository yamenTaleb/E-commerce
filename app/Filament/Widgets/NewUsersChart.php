<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Filament\Widgets\ChartWidget;

class NewUsersChart extends ChartWidget
{
    protected static ?string $heading = 'New Users';
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
        // Get new users data for the current year
        $usersData = DB::table('users')
            ->select(
                DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
                DB::raw('COUNT(*) as count')
            )
            ->whereYear('created_at', now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count', 'month');

        // Generate all months of the year with 0 as default
        $months = collect(range(1, 12))->mapWithKeys(function ($month) {
            $date = now()->setMonth($month)->startOfMonth();
            return [$date->format('Y-m') => 0];
        });

        // Merge actual data with default months
        $chartData = $months->merge($usersData);

        return [
            'datasets' => [
                [
                    'label' => 'New Users',
                    'data' => $chartData->values()->toArray(),
                    'borderColor' => 'rgb(16, 185, 129)', // Green color
                    'backgroundColor' => 'rgba(16, 185, 129, 0.2)',
                    'fill' => true,
                    'tension' => 0.4,
                ],
            ],
            'labels' => $chartData->keys()->map(fn ($month) => now()->parse($month)->format('M'))->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getOptions(): array
    {
        return [
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'ticks' => [
                        'precision' => 0,
                    ],
                ],
            ],
            'plugins' => [
                'legend' => [
                    'display' => false,
                ],
            ],
            'barThickness' => 'flex',
            'maxBarThickness' => 40,
        ];
    }
}
