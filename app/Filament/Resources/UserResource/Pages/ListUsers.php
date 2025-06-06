<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Pages\ListRecords\Tab;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

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
            "Verified" => Tab::make('Verified')->modifyQueryUsing(fn ($query) => $query->whereNotNull('email_verified_at')),
            "Unverified" => Tab::make('Unverified')->modifyQueryUsing(fn ($query) => $query->whereNull('email_verified_at')),
        ];
    }
}
