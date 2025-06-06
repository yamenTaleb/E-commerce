<?php

namespace App\Filament\Resources\UserResource\RelationManagers;

use App\Filament\Filters\DateRangeFilter;
use App\Filament\Filters\IssueFilter;
use App\Filament\Tables\IssueTable;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class IssuesRelationManager extends RelationManager
{
    protected static string $relationship = 'issues';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'considered' => 'Considered',
                        'solved' => 'Solved',
                    ])
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('product.name')
            ->columns(IssueTable::getColumns())
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'considered' => 'Considered',
                        'solved' => 'Solved',
                    ]),
                ...IssueFilter::getFilters()
            ])
            ->headerActions([
            ])
            ->actions([
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
