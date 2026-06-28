<?php

namespace App\Filament\Resources\Pages\Schemas;

use App\Models\Locale;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Publishing')
                    ->columns(2)
                    ->schema([
                        Select::make('template')
                            ->options([
                                'default' => 'Default',
                                'home' => 'Home',
                                'landing' => 'Landing',
                            ])
                            ->required()
                            ->default('default'),
                        Select::make('status')
                            ->options([
                                'draft' => 'Draft',
                                'published' => 'Published',
                                'archived' => 'Archived',
                            ])
                            ->required()
                            ->default('draft'),
                        DateTimePicker::make('published_at'),
                        TextInput::make('sort_order')
                            ->required()
                            ->numeric()
                            ->default(0),
                        Toggle::make('is_home')
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
                                Textarea::make('excerpt')
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
                Section::make('Page sections')
                    ->schema([
                        Repeater::make('sections')
                            ->relationship()
                            ->schema([
                                TextInput::make('key')
                                    ->required()
                                    ->maxLength(255),
                                Select::make('component')
                                    ->options([
                                        'hero' => 'Hero',
                                        'content' => 'Content',
                                        'cards' => 'Cards',
                                        'carousel' => 'Carousel',
                                        'accordion' => 'Accordion',
                                        'cta' => 'Call to action',
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
                                KeyValue::make('settings')
                                    ->columnSpanFull(),
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
                                        TextInput::make('eyebrow')
                                            ->maxLength(255),
                                        TextInput::make('title')
                                            ->maxLength(255),
                                        Textarea::make('subtitle')
                                            ->rows(2),
                                        MarkdownEditor::make('body')
                                            ->columnSpanFull(),
                                        TextInput::make('cta_label')
                                            ->maxLength(255),
                                        TextInput::make('cta_url')
                                            ->url()
                                            ->maxLength(255),
                                    ])
                                    ->columns(2)
                                    ->maxItems(2)
                                    ->defaultItems(2)
                                    ->columnSpanFull(),
                            ])
                            ->columns(2)
                            ->orderColumn('sort_order')
                            ->addActionLabel('Add section'),
                    ]),
            ]);
    }
}
