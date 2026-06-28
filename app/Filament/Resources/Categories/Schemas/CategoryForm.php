<?php

namespace App\Filament\Resources\Categories\Schemas;

use App\Models\Category;
use App\Models\Locale;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Publishing')
                    ->columns(2)
                    ->schema([
                        Select::make('parent_id')
                            ->label('Parent category')
                            ->options(fn (): array => Category::query()
                                ->with('translations')
                                ->orderBy('sort_order')
                                ->get()
                                ->mapWithKeys(fn (Category $category): array => [
                                    $category->id => $category->title('id') ?: "Category #{$category->id}",
                                ])
                                ->all())
                            ->searchable(),
                        Select::make('type')
                            ->options([
                                'place' => 'Place',
                                'accommodation' => 'Accommodation',
                                'post' => 'Post',
                                'general' => 'General',
                            ])
                            ->required()
                            ->default('general'),
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
                                TextInput::make('name')
                                    ->required()
                                    ->maxLength(255),
                                TextInput::make('slug')
                                    ->required()
                                    ->maxLength(255),
                                Textarea::make('description')
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
