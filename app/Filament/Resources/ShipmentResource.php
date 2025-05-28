<?php

namespace App\Filament\Resources;

use App\Filament\Exports\ShipmentExporter;
use App\Filament\Filters\DateRangeFilter;
use App\Filament\Forms\ShipmentForm;
use App\Filament\Resources\ShipmentResource\Pages;
use App\Filament\Resources\ShipmentResource\RelationManagers;
use App\Filament\Tables\ShipmentTable;
use App\Models\Shipment;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ExportAction;
use Filament\Tables\Actions\ExportBulkAction;
use Filament\Tables\Table;

class ShipmentResource extends Resource
{
    protected static ?string $model = Shipment::class;

    protected static ?string $navigationIcon = 'heroicon-o-truck';

    public static function form(Form $form): Form
    {
        return $form
            ->schema(ShipmentForm::getSchema());
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns(ShipmentTable::getColumns())
            ->filters([
                DateRangeFilter::make('shipment_date')
                    ->column('shipment_date'),
                DateRangeFilter::make('delivery_date')
                    ->column('delivery_date')
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->headerActions([
                ExportAction::make()->exporter(ShipmentExporter::class),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
                ExportBulkAction::make()->exporter(ShipmentExporter::class),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListShipments::route('/'),
            'create' => Pages\CreateShipment::route('/create'),
            'edit' => Pages\EditShipment::route('/{record}/edit'),
        ];
    }
}
