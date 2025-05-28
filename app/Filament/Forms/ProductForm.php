<?php

namespace App\Filament\Forms;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Grid;

class ProductForm
{
    public static function getSchema(): array
    {
        return [
            Section::make('Product Information')
                ->schema([
                    TextInput::make('name')
                        ->required()
                        ->maxLength(255)
                        ->columnSpanFull()
                        ->placeholder('Enter product name'),

                    RichEditor::make('description')
                        ->maxLength(2048)
                        ->columnSpanFull()
                        ->toolbarButtons([
                            'bold',
                            'bulletList',
                            'h2',
                            'h3',
                            'italic',
                            'link',
                            'orderedList',
                            'redo',
                            'strike',
                            'underline',
                            'undo',
                        ]),
                ])
                ->columns(1),

            Section::make('Pricing & Inventory')
                ->schema([
                    Grid::make(3)
                        ->schema([
                            TextInput::make('price')
                                ->required()
                                ->numeric()
                                ->prefix('$')
                                ->minValue(0.01)
                                ->step(0.01),

                            TextInput::make('stock_quantity')
                                ->required()
                                ->numeric()
                                ->minValue(0)
                                ->step(1)
                                ->label('Stock Quantity'),
                            TextInput::make('discount')
                                ->numeric()
                                ->minValue(0)
                                ->maxValue(100)
                                ->step(1)
                                ->suffix('%')
                                ->label('Discount'),
                        ]),
                ]),

            Section::make('Product Images')
                ->schema([
                    Repeater::make('images')
                        ->relationship('productImages')
                        ->schema([
                            FileUpload::make('name')
                                ->directory('product-images')
                                ->image()
                                ->imageEditor()
                                ->required()
                                ->columnSpan(2),
                            Toggle::make('is_primary')
                                ->label('Set as primary image')
                                ->inline(false)
                                ->default(false)
                                ->columnSpan(2),
                        ])
                        ->createItemButtonLabel('Add Another Image')
                        ->label('')
                        ->columns(2)
                        ->grid(1)
                ])
        ];
    }
}
