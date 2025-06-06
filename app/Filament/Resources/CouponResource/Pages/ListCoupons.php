<?php

namespace App\Filament\Resources\CouponResource\Pages;

use App\Filament\Resources\CouponResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Pages\ListRecords\Tab;

class ListCoupons extends ListRecords
{
    protected static string $resource = CouponResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        $now = now();

        return [
            "All" => Tab::make('All'),
            "Active" => Tab::make('Active')
                ->modifyQueryUsing(fn ($query) => $query->where('expires_at', '>', $now)),
            "Expired" => Tab::make('Expired')
                ->modifyQueryUsing(fn ($query) => $query->where('expires_at', '<=', $now)),
        ];
    }
}
