<?php

namespace App\Filament\Resources\UserResource\RelationManagers;

use App\Filament\Filters\ReviewFilter;
use App\Filament\Tables\ReviewTable;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\Summarizers\Average;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ReviewsRelationManager extends RelationManager
{
    protected static string $relationship = 'reviews';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('product.name')
                    ->label('Product Name')
                    ->searchable()
                    ->sortable()
                    ->weight('medium')
                    ->description(fn ($record) => \Illuminate\Support\Str::limit($record->comment, 50))
                    ->wrap(),
                ...ReviewTable::getColumns(),
            ])
            ->filters(ReviewFilter::getFilters())
            ->headerActions([
            ])
            ->actions([
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
