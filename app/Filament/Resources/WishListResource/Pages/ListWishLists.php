<?php

namespace App\Filament\Resources\WishListResource\Pages;

use App\Filament\Resources\WishListResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListWishLists extends ListRecords
{
    protected static string $resource = WishListResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
