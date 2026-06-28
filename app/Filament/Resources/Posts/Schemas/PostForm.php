<?php

namespace App\Filament\Resources\Posts\Schemas;

use App\Models\Category;
use App\Models\Locale;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Publishing')
                    ->columns(2)
                    ->schema([
                        Select::make('category_id')
                            ->label('Category')
                            ->options(fn (): array => Category::query()
                                ->whereIn('type', ['post', 'general'])
                                ->with('translations')
                                ->orderBy('sort_order')
                                ->get()
                                ->mapWithKeys(fn (Category $category): array => [
                                    $category->id => $category->title('id') ?: "Category #{$category->id}",
                                ])
                                ->all())
                            ->searchable(),
                        Select::make('author_id')
                            ->relationship('author', 'name')
                            ->searchable()
                            ->preload(),
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
                        Toggle::make('is_featured')
                            ->required(),
                    ]),
                Section::make('Media')
                    ->schema([
                        Select::make('mediaAssets')
                            ->label('Gallery media')
                            ->relationship('mediaAssets', 'path')
                            ->multiple()
                            ->preload()
                            ->searchable(),
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
            ]);
    }
}
