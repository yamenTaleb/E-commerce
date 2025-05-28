<?php

namespace App\Filament\Forms;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;

class OrderForm
{
    public static function getSchema(): array
    {
        return [
            grid::make(2)
                ->schema([
                    TextInput::make('session_id')
                        ->required()
                        ->unique(ignoreRecord: true)
                        ->string(256)
                        ->label('Session ID')
                        ->disabled(),

                    DatePicker::make('order_date')
                        ->required()
                        ->label('Order Date')
                        ->disabled(),
                ]),

            Select::make('status')
                ->options([
                    'paid' => 'Paid',
                    'unpaid' => 'Unpaid',
                    'canceled' => 'Canceled',
                    'shipped' => 'Shipped',
                    'refunded' => 'Refunded',
                    'delivered' => 'Delivered',
                    'processing' => 'Processing'
                ])
                ->required()
                ->label('Status'),

            TextInput::make('total')
                ->required()
                ->numeric()
                ->step(1)
                ->prefix('$')
                ->minValue(0.01)
                ->step(0.01)
                ->label('Total')
                ->disabled(),
        ];
    }
}
