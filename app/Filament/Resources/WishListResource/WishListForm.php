<?php

namespace App\Filament\Resources\WishListResource\Forms;

use Filament\Forms;
use Filament\Forms\Form;

class WishListForm
{
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required()
                    ->searchable()
                    ->preload()
                    ->label('Customer'),


                Forms\Components\Select::make('product_id')
                    ->relationship('product', 'name')
                    ->required()
                    ->label('Product'),

                Forms\Components\Textarea::make('comment')
                    ->label('Comment')
                    ->maxLength(500)
                    ->columnSpanFull(),
            ]);
    }
}
