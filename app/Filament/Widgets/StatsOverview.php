<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class StatsOverview extends BaseWidget
{
    protected static ?string $pollingInterval = '30s';
    protected static bool $isLazy = true;

    protected function getStats(): array
    {
        // Total Revenue
        $totalRevenue = DB::table('orders')
            ->whereIn('status', ['paid', 'shipped', 'delivered'])
            ->sum('total_price');

        // New Orders (last 30 days)
        $newOrders = Order::where('order_date', '>=', now()->subDays(30))->count();

        // Total Customers
        $totalCustomers = User::whereHas('orders')->count();

        // Total Products
        $totalProducts = Product::count();

        // Get revenue data for the last 7 days
        $revenueData = DB::table('orders')
            ->select(
                DB::raw('DATE(order_date) as date'),
                DB::raw('SUM(total_price) as total')
            )
            ->whereIn('status', ['paid', 'shipped', 'delivered'])
            ->where('order_date', '>=', now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('total', 'date')
            ->map(fn ($value) => (float) $value);

        // Get order count data for the last 7 days
        $orderData = DB::table('orders')
            ->select(DB::raw('DATE(order_date) as date'), DB::raw('COUNT(*) as count'))
            ->where('order_date', '>=', now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('count', 'date');

        // Fill in missing days with 0
        $dates = collect();
        foreach (range(0, 6) as $day) {
            $dates->put(now()->subDays($day)->format('Y-m-d'), 0);
        }

        $revenueChartData = $dates->merge($revenueData)->values();
        $orderChartData = $dates->merge($orderData)->values();

        return [
            Stat::make('Total Revenue', '$' . number_format($totalRevenue, 2))
                ->description('All time revenue')
                ->descriptionIcon('heroicon-o-currency-dollar')
                ->color('success'),

            Stat::make('New Orders (30d)', number_format($newOrders))
                ->description(($newOrders > 0 ? '+' : '') . number_format($newOrders) . ' from last period')
                ->descriptionIcon('heroicon-o-shopping-bag')
                ->color('primary'),

            Stat::make('Total Customers', number_format($totalCustomers))
                ->description('Active customers with orders')
                ->descriptionIcon('heroicon-o-users')
                ->color('info'),

            Stat::make('Total Products', number_format($totalProducts))
                ->description('Available in store')
                ->descriptionIcon('heroicon-o-cube')
                ->color('warning'),

            Stat::make('Revenue (7d)', '$' . number_format($revenueData->sum(), 2))
                ->chart($revenueChartData->toArray())
                ->color('success'),

            Stat::make('Orders (7d)', number_format($orderData->sum()))
                ->chart($orderChartData->toArray())
                ->color('primary'),
        ];
    }
}
