<?php

namespace App\Filament\Forms;

use App\Enums\OrderStatusEnum;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;

class ShipmentForm
{
    public static function getSchema(): array
    {
        return  [
            Section::make('Shipment Information')
                ->description('Enter the basic details for this shipment')
                ->icon('heroicon-o-truck')
                ->schema([
                    Grid::make(1)
                        ->schema([
                            Select::make('order_id')
                                ->searchable()
                                ->required()
                                ->relationship('order', 'session_id')
                                ->preload()
                                ->label('Order')
                                ->disabledOn('edit'),

                            Select::make('shipment_status')
                                ->label('Status')
                                ->required()
                                ->options([
                                    'shipped' => OrderStatusEnum::SHIPPED->label(),
                                    'delivered' => OrderStatusEnum::DELIVERED->label(),
                                    'canceled' => OrderStatusEnum::CANCELED->label(),
                                ])
                                ->default('shipped'),
                        ]),

                    DateTimePicker::make('shipment_date')
                        ->label('Shipment Date')
                        ->required()
                        ->minDate(now())
                        ->default(now())
                        ->columnSpan(1)
                        ->displayFormat('M d, Y')
                        ->prefixIcon('heroicon-o-calendar')
                        ->maxWidth('md'),

                    DateTimePicker::make('delivery_date')
                        ->label('Delivery Date')
                        ->required()
                        ->minDate(now())
                        ->default(now()->addDays(1))
                        ->displayFormat('M d, Y')
                        ->columnSpanFull()
                        ->prefixIcon('heroicon-o-calendar')
                        ->maxWidth('md'),
                ])->aside(),
        ];
    }
}
