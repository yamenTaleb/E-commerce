<?php

namespace App\Filament\Resources;

use App\Filament\Exports\UserExporter;
use App\Filament\Forms\UserForm;
use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use App\Filament\Tables\UserTable;
use App\Filament\Filters\UserFilter;
use Filament\Tables\Actions\ExportAction;
use Filament\Tables\Table;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-circle';

    public static function form(Form $form): Form
    {
        return $form
            ->schema(UserForm::getSchema());
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns(UserTable::getColumns())
            ->filters(UserFilter::getFilters())
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->headerActions([
                ExportAction::make()->exporter(UserExporter::class),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
                Tables\Actions\ExportBulkAction::make()->exporter(UserExporter::class),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\ReviewsRelationManager::class,
            RelationManagers\OrdersRelationManager::class,
            RelationManagers\IssuesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
            'view' => Pages\ViewUser::route('/{record}'),
        ];
    }
}
