<?php

namespace App\Filament\Resources\NavigationItems\Schemas;

use App\Models\Locale;
use App\Models\NavigationItem;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class NavigationItemForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Navigation target')
                    ->columns(2)
                    ->schema([
                        Select::make('parent_id')
                            ->label('Parent item')
                            ->options(fn (): array => NavigationItem::query()
                                ->with('translations')
                                ->orderBy('sort_order')
                                ->get()
                                ->mapWithKeys(fn (NavigationItem $item): array => [
                                    $item->id => $item->title('id') ?: "Navigation #{$item->id}",
                                ])
                                ->all())
                            ->searchable(),
                        Select::make('route_name')
                            ->options([
                                'home' => 'Home',
                                'places.index' => 'Places',
                                'accommodations.index' => 'Accommodations',
                                'posts.index' => 'News',
                                'travel.index' => 'Travel information',
                            ])
                            ->searchable(),
                        TextInput::make('url')
                            ->maxLength(255),
                        Select::make('target')
                            ->options([
                                '_self' => 'Same tab',
                                '_blank' => 'New tab',
                            ])
                            ->required()
                            ->default('_self'),
                        Select::make('status')
                            ->options([
                                'draft' => 'Draft',
                                'published' => 'Published',
                                'archived' => 'Archived',
                            ])
                            ->required()
                            ->default('published'),
                        TextInput::make('sort_order')
                            ->required()
                            ->numeric()
                            ->default(0),
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
                                TextInput::make('label')
                                    ->required()
                                    ->maxLength(255),
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
