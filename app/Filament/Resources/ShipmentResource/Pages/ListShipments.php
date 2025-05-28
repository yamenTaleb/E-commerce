<?php

namespace App\Filament\Resources\ShipmentResource\Pages;

use App\Filament\Resources\ShipmentResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Pages\ListRecords\Tab;

class ListShipments extends ListRecords
{
    protected static string $resource = ShipmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            "All" => Tab::make('All'),
            "Shipped" => Tab::make('Shipped')->modifyQueryUsing(fn ($query) => $query->where('shipment_status', 'Shipped')),
            "Delivered" => Tab::make('Delivered')->modifyQueryUsing(fn ($query) => $query->where('shipment_status', 'delivered')),
            "Cancelled" => Tab::make('Cancelled')->modifyQueryUsing(fn ($query) => $query->where('shipment_status', 'cancelled')),
        ];
    }
}
