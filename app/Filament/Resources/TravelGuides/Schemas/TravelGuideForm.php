<?php

namespace App\Filament\Resources\TravelGuides\Schemas;

use App\Models\Locale;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class TravelGuideForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Publishing')
                    ->columns(2)
                    ->schema([
                        TextInput::make('key')
                            ->required()
                            ->maxLength(255),
                        Select::make('layout')
                            ->options([
                                'content' => 'Content',
                                'accordion' => 'Accordion',
                                'timeline' => 'Timeline',
                            ])
                            ->required()
                            ->default('content'),
                        Select::make('status')
                            ->options([
                                'draft' => 'Draft',
                                'published' => 'Published',
                                'archived' => 'Archived',
                            ])
                            ->required()
                            ->default('draft'),
                        TextInput::make('sort_order')
                            ->required()
                            ->numeric()
                            ->default(0),
                        Toggle::make('is_featured')
                            ->required(),
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
                                TextInput::make('title')
                                    ->required()
                                    ->maxLength(255),
                                TextInput::make('slug')
                                    ->required()
                                    ->maxLength(255),
                                Textarea::make('intro')
                                    ->rows(3)
                                    ->columnSpanFull(),
                                MarkdownEditor::make('body')
                                    ->columnSpanFull(),
                                TextInput::make('meta_title')
                                    ->maxLength(255),
                                Textarea::make('meta_description')
                                    ->rows(3),
                            ])
                            ->columns(2)
                            ->minItems(1)
                            ->maxItems(2)
                            ->defaultItems(2)
                            ->addActionLabel('Add translation'),
                    ]),
                Section::make('Route groups')
                    ->schema([
                        Repeater::make('routeGroups')
                            ->relationship()
                            ->schema([
                                Select::make('status')
                                    ->options([
                                        'draft' => 'Draft',
                                        'published' => 'Published',
                                        'archived' => 'Archived',
                                    ])
                                    ->required()
                                    ->default('draft'),
                                TextInput::make('sort_order')
                                    ->required()
                                    ->numeric()
                                    ->default(0),
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
                                        TextInput::make('title')
                                            ->required()
                                            ->maxLength(255),
                                        Textarea::make('summary')
                                            ->rows(2),
                                    ])
                                    ->columns(2)
                                    ->maxItems(2)
                                    ->defaultItems(2)
                                    ->columnSpanFull(),
                                Repeater::make('routes')
                                    ->relationship()
                                    ->schema([
                                        TextInput::make('transport_mode')
                                            ->maxLength(255),
                                        TextInput::make('departure_time')
                                            ->maxLength(255),
                                        TextInput::make('distance_value')
                                            ->numeric(),
                                        TextInput::make('distance_unit')
                                            ->maxLength(24)
                                            ->default('km'),
                                        Select::make('status')
                                            ->options([
                                                'draft' => 'Draft',
                                                'published' => 'Published',
                                                'archived' => 'Archived',
                                            ])
                                            ->required()
                                            ->default('draft'),
                                        TextInput::make('sort_order')
                                            ->required()
                                            ->numeric()
                                            ->default(0),
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
                                                TextInput::make('origin')
                                                    ->maxLength(255),
                                                TextInput::make('destination')
                                                    ->maxLength(255),
                                                Textarea::make('route_summary')
                                                    ->rows(2),
                                                Textarea::make('notes')
                                                    ->rows(2),
                                            ])
                                            ->columns(2)
                                            ->maxItems(2)
                                            ->defaultItems(2)
                                            ->columnSpanFull(),
                                    ])
                                    ->columns(2)
                                    ->orderColumn('sort_order')
                                    ->columnSpanFull()
                                    ->addActionLabel('Add route'),
                            ])
                            ->columns(2)
                            ->orderColumn('sort_order')
                            ->addActionLabel('Add route group'),
                    ]),
            ]);
    }
}
