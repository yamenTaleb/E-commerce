<?php

namespace App\Filament\Resources\OrderResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrderDetailsRelationManager extends RelationManager
{
    protected static string $relationship = 'orderDetails';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('id')
                    ->required()
                    ->disabled()
                    ->maxLength(255),

                Select::make('product_id')
                    ->relationship(name: 'product', titleAttribute: 'name')
                    ->required()
                    ->searchable()
                    ->preload()
                    ->disabledOn('edit'),

                TextInput::make('quantity')
                    ->required()
                    ->numeric()
                    ->minValue(0)
                    ->step(1)
                    ->label('Quantity'),
                TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->prefix('$')
                    ->minValue(0.01)
                    ->step(0.01),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('#'),

                TextColumn::make('product.name')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('quantity')
                    ->formatStateUsing(fn ($state) => $state . ' units'),

                TextColumn::make('price')
                    ->label('Price')
                    ->money('USD')
                    ->sortable()
                    ->color('success')
                    ->weight('bold')
                    ->summarize(Sum::make()),

                TextColumn::make('created_at')
                    ->label('Added On')
                    ->dateTime('M d, Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->color('gray')
                    ->description(fn ($record) => $record->created_at->diffForHumans()),

                TextColumn::make('updated_at')
                    ->label('Updated On')
                    ->dateTime('M d, Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->color('gray')
                    ->description(fn ($record) => $record->updated_at->diffForHumans()),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
