<?php

namespace App\Filament\Resources\CouponResource\Forms;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\DateTimePicker;

class CouponForm
{
    public static function form(Form $form): Form
    {
        return $form->schema([
            Section::make('Coupon Information')
                ->description('Enter the basic details for this coupon')
                ->icon('heroicon-o-ticket')
                ->schema([
                    Grid::make(2)
                        ->schema([
                            Forms\Components\TextInput::make('code')
                                ->label('Coupon Code')
                                ->required()
                                ->unique('coupons', 'code', ignoreRecord: true)
                                ->maxLength(20)
                                ->columnSpan(1)
                                ->prefixIcon('heroicon-o-tag')
                                ->suffixIcon('heroicon-m-sparkles')
                                ->helperText('Enter a unique code (e.g., SUMMER25)')
                                ->hintAction(
                                    Forms\Components\Actions\Action::make('generate')
                                        ->icon('heroicon-m-sparkles')
                                        ->action(fn (Forms\Set $set) =>
                                            $set('code', strtoupper(\Illuminate\Support\Str::random(8))))
                                ),

                            Forms\Components\TextInput::make('discount_amount')
                                ->label('Discount Amount')
                                ->required()
                                ->numeric()
                                ->minValue(0.01)
                                ->step(0.01)
                                ->prefix('$')
                                ->suffix('USD')
                                ->columnSpan(1)
                                ->prefixIcon('heroicon-o-currency-dollar')
                                ->helperText('The discount amount in USD')
                                ->hint('Minimum $0.01'),
                        ]),

                    DateTimePicker::make('expires_at')
                        ->label('Expiration Date & Time')
                        ->required()
                        ->minDate(now())
                        ->default(now()->addMonth())
                        ->displayFormat('M d, Y H:i')
                        ->prefixIcon('heroicon-o-clock')
                        ->helperText('When this coupon should expire')
                        ->columnSpan(1)
                        ->maxWidth('md'),
                ])
                ->columns(1),
        ]);
    }
}
