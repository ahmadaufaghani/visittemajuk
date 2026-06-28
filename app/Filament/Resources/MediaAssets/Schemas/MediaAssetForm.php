<?php

namespace App\Filament\Resources\MediaAssets\Schemas;

use App\Models\Locale;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class MediaAssetForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('File')
                    ->columns(2)
                    ->schema([
                        Select::make('disk')
                            ->options([
                                'public' => 'Public',
                            ])
                            ->required()
                            ->default('public'),
                        Select::make('status')
                            ->options([
                                'draft' => 'Draft',
                                'published' => 'Published',
                                'archived' => 'Archived',
                            ])
                            ->required()
                            ->default('published'),
                        FileUpload::make('path')
                            ->label('Image')
                            ->disk('public')
                            ->directory('visit-temajuk')
                            ->visibility('public')
                            ->image()
                            ->imageEditor()
                            ->required()
                            ->columnSpanFull(),
                        TextInput::make('sort_order')
                            ->required()
                            ->numeric()
                            ->default(0),
                        TextInput::make('dominant_color')
                            ->maxLength(32),
                        TextInput::make('credit_url')
                            ->url()
                            ->maxLength(255)
                            ->columnSpanFull(),
                    ]),
                Section::make('Technical metadata')
                    ->columns(2)
                    ->collapsed()
                    ->schema([
                        TextInput::make('mime_type')
                            ->maxLength(255),
                        TextInput::make('size')
                            ->numeric(),
                        TextInput::make('width')
                            ->numeric(),
                        TextInput::make('height')
                            ->numeric(),
                    ]),
                Section::make('Translations')
                    ->schema([
                        Repeater::make('translations')
                            ->relationship()
                            ->schema([
                                Select::make('locale_code')
                                    ->label('Language')
                                    ->options(fn (): array => Locale::query()
                                        ->where('is_active', true)
                                        ->orderBy('sort_order')
                                        ->pluck('native_name', 'code')
                                        ->all())
                                    ->required()
                                    ->disableOptionsWhenSelectedInSiblingRepeaterItems(),
                                TextInput::make('alt_text')
                                    ->maxLength(255),
                                Textarea::make('caption')
                                    ->rows(2),
                                TextInput::make('credit')
                                    ->maxLength(255),
                            ])
                            ->columns(2)
                            ->maxItems(2)
                            ->defaultItems(2)
                            ->addActionLabel('Add translation'),
                    ]),
            ]);
    }
}
