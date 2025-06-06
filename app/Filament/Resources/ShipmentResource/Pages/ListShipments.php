<?php

namespace App\Filament\Resources\ShipmentResource\Pages;

use App\Enums\OrderStatusEnum;
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
            "Shipped" => Tab::make(OrderStatusEnum::SHIPPED->label())->modifyQueryUsing(fn ($query) => $query->where('shipment_status', OrderStatusEnum::SHIPPED->value)),
            "Delivered" => Tab::make(OrderStatusEnum::DELIVERED->label())->modifyQueryUsing(fn ($query) => $query->where('shipment_status', OrderStatusEnum::DELIVERED->value)),
            "Canceled" => Tab::make(OrderStatusEnum::CANCELED->label())->modifyQueryUsing(fn ($query) => $query->where('shipment_status', OrderStatusEnum::CANCELED->value)),
        ];
    }
}
