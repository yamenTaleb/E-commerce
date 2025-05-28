<?php

namespace App\Filament\Forms;

use App\Enums\IssuePriority;
use App\Enums\IssueStatus;
use App\Models\User;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Illuminate\Support\Str;

class IssueForm
{
    public static function getSchema(): array
    {
        return [
            Section::make('Issue Details')
                ->schema([
                    TextInput::make('subject')
                        ->label('Subject')
                        ->required()
                        ->disabled()
                        ->maxLength(255)
                        ->columnSpanFull()
                        ->live(onBlur: true)
                        ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state))),

                    Select::make('status')
                        ->options([
                            'pending' => 'Pending',
                            'considered' => 'Considered',
                            'solved' => 'Solved',
                        ]),

//                    Select::make('priority')
//                        ->options(IssuePriority::class)
//                        ->default('medium')
//                        ->required()
//                        ->native(false),

                    Select::make('user_id')
                        ->label('Assign To')
                        ->relationship('customer', 'name')
                        ->disabled(),


//                    Select::make('reported_by')
//                        ->label('Reported By')
//                        ->options(User::query()->pluck('name', 'id'))
//                        ->searchable()
//                        ->preload()
//                        ->default(auth()->id())
//                        ->disabled()
//                        ->dehydrated(),
                ])
                ->columns(2),

            Section::make('Description')
                ->schema([
                    RichEditor::make('description')
                        ->required()
                        ->disableToolbarButtons([
                            'attachFiles',
                        ])
                        ->columnSpanFull(),
                ])->visibleOn('view'),


        ];
    }
}
