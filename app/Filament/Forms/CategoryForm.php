<?php

namespace App\Filament\Forms;

use App\Models\Category;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\TextInput;

class CategoryForm
{
    public static function getSchema(): array
    {
        return [
            TextInput::make('name')->required()->string(256)->label('Name'),
            Select::make('category_parent_id')
                ->required()
                ->string(256)
                ->label('Parent Category')
                ->searchable()
                ->options(Category::all()->pluck('name', 'id'))
                ->preload(),
            RichEditor::make('description')
                ->toolbarButtons([
                    'attachFiles',
                    'blockquote',
                    'bold',
                    'bulletList',
                    'codeBlock',
                    'h2',
                    'h3',
                    'italic',
                    'link',
                    'orderedList',
                    'redo',
                    'strike',
                    'underline',
                    'undo',
                ])
                ->columnSpanFull()
                ->string(2048)
                ->label('Description'),
        ];
    }
}
