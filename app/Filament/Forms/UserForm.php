<?php

namespace App\Filament\Forms;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;

class UserForm
{
    public static function getSchema(): array
    {
        return [
            Tabs::make('Heading')
                ->tabs([
                    Tab::make('Personal Information')
                        ->schema([
                            TextInput::make('name')->required()->string(256)->label('Name'),
                            TextInput::make('email')
                                ->email()
                                ->required()
                                ->string(256)
                                ->label('Email')
                                ->unique(ignoreRecord: true),
                        ]),
                    Tab::make('Security Information')
                        ->schema([
                            TextInput::make('password')
                                ->password()
                                ->required()
                                ->string(256)
                                ->label('Password')
                                ->dehydrateStateUsing(fn ($state) => bcrypt($state)),
                        ])->visibleOn('create'),
                    Tab::make('Phone and Address')
                        ->schema([
                            TextInput::make('phone')
                                ->string(256)
                                ->label('Phone Number'),
                            TextInput::make('address')
                                ->string(256)
                                ->label('Address'),
                        ]),
                    Tab::make('Image')
                        ->schema([
                            FileUpload::make('image')
                                ->directory("users")
                                ->image()
                                ->imageEditor()
                                ->maxSize(5120) // 5MB
                                ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                                ->label('Profile Image')
                                ->helperText('Upload a square image for best results. Max size: 5MB.')
                                ->columnSpan(2),
                        ])
                        ->columnSpan(6)
                ])->columnSpan('full'),
        ];
    }
}
