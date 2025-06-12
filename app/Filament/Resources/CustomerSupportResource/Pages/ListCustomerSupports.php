<?php

namespace App\Filament\Resources\CustomerSupportResource\Pages;

use App\Filament\Resources\CustomerSupportResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Pages\ListRecords\Tab;

class ListCustomerSupports extends ListRecords
{
    protected static string $resource = CustomerSupportResource::class;

    protected function getHeaderActions(): array
    {
        return [
        ];
    }

    public function getTabs(): array
    {
        return [
            "All" => Tab::make('All'),
            "considered" => Tab::make('Considered')->modifyQueryUsing(fn ($query) => $query->where('status', 'considered')),
            "pending" => Tab::make('Pending')->modifyQueryUsing(fn ($query) => $query->where('status', 'pending')),
            "solved" => Tab::make('Solved')->modifyQueryUsing(fn ($query) => $query->where('status', 'solved')),
        ];
    }
}
