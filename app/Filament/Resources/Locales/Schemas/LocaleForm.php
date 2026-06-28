<?php

namespace App\Filament\Resources\Locales\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class LocaleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Language')
                    ->columns(2)
                    ->schema([
                        TextInput::make('code')
                            ->required()
                            ->maxLength(5),
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('native_name')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('sort_order')
                            ->required()
                            ->numeric()
                            ->default(0),
                        Toggle::make('is_default')
                            ->required(),
                        Toggle::make('is_active')
                            ->required(),
                    ]),
            ]);
    }
}
