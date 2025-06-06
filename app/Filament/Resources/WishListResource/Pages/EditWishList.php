<?php

namespace App\Filament\Resources\WishListResource\Pages;

use App\Filament\Resources\WishListResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditWishList extends EditRecord
{
    protected static string $resource = WishListResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
