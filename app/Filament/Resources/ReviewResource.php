<?php

namespace App\Filament\Resources;

use App\Filament\Exports\ReviewExporter;
use App\Filament\Filters\ReviewFilter;
use App\Filament\Resources\ReviewResource\Pages;
use App\Filament\Tables\ReviewTable;
use App\Models\Review;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ExportAction;
use Filament\Tables\Actions\ExportBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ReviewResource extends Resource
{
    protected static ?string $model = Review::class;

    protected static ?string $navigationIcon = 'heroicon-o-star';

    protected static ?string $navigationLabel = 'Reviews';


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label('User Name')
                    ->searchable()
                    ->sortable()
                    ->weight('medium')
                    ->description(fn ($record) => \Illuminate\Support\Str::limit($record->comment, 50))
                    ->wrap()
                    ->url(fn ($record) => route('filament.admin.resources.users.view', $record->user_id)),

                TextColumn::make('product.name')
                    ->label('Product Name')
                    ->searchable()
                    ->sortable()
                    ->url(fn ($record) => route('filament.admin.resources.products.view', $record->product->slug)),

                ...ReviewTable::getColumns(),
            ])
            ->filters(ReviewFilter::getFilters())
            ->actions([
                Tables\Actions\DeleteAction::make(),
            ])
            ->headerActions([
                ExportAction::make()->exporter(ReviewExporter::class),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
                ExportBulkAction::make()->exporter(ReviewExporter::class),
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
            'index' => Pages\ListReviews::route('/'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }
}
