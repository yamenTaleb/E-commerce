<?php

namespace App\Filament\Resources;

use App\Filament\Exports\WishListExporter;
use App\Filament\Resources\WishListResource\Forms\WishListForm;
use App\Filament\Resources\WishListResource\Pages;
use App\Filament\Resources\WishListResource\RelationManagers;
use App\Filament\Resources\WishListResource\Tables\WishListColumns;
use App\Models\WishList;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ExportAction;
use Filament\Tables\Actions\ExportBulkAction;
use Filament\Tables\Table;

class WishListResource extends Resource
{
    protected static ?string $model = WishList::class;

    protected static ?string $navigationIcon = 'heroicon-o-heart';

    public static function form(Form $form): Form
    {
        return WishListForm::form($form);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns(WishListColumns::getColumns())
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->headerActions([
                ExportAction::make()->exporter(WishListExporter::class),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
                ExportBulkAction::make()->exporter(WishListExporter::class),
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
            'index' => Pages\ListWishLists::route('/'),
            'create' => Pages\CreateWishList::route('/create'),
            'edit' => Pages\EditWishList::route('/{record}/edit'),
        ];
    }
}
