<?php

namespace App\Filament\Resources;

use App\Filament\Exports\CustomerSupportExporter;
use App\Filament\Filters\IssueFilter;
use App\Filament\Forms\IssueForm;
use App\Filament\Resources\CustomerSupportResource\Pages;
use App\Filament\Resources\CustomerSupportResource\RelationManagers;
use App\Filament\Tables\IssueTable;
use App\Models\CustomerSupport;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ExportAction;
use Filament\Tables\Actions\ExportBulkAction;
use Filament\Tables\Table;

class CustomerSupportResource extends Resource
{
    protected static ?string $model = CustomerSupport::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-oval-left-ellipsis';

    public static function form(Form $form): Form
    {
        return $form
            ->schema(IssueForm::getSchema());
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns(IssueTable::getColumns())
            ->filters([
                ...IssueFilter::getFilters()
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->headerActions([
                ExportAction::make()->exporter(CustomerSupportExporter::class),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
                ExportBulkAction::make()->exporter(CustomerSupportExporter::class),
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
            'index' => Pages\ListCustomerSupports::route('/'),
            'create' => Pages\CreateCustomerSupport::route('/create'),
            'edit' => Pages\EditCustomerSupport::route('/{record}/edit'),
        ];
    }
}
