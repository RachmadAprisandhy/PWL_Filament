<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\IconEntry;
use Filament\Schemas\Schema;

class ProductInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                Tabs::make('Product Tabs')
                    ->vertical()
                    ->tabs([

                        Tab::make('Product Info')
                            ->icon('heroicon-o-information-circle')
                            ->schema([
                                Section::make('Product Information')
                                    ->schema([
                                        TextEntry::make('name')
                                            ->label('Product Name')
                                            ->weight('bold')
                                            ->color('primary'),

                                        TextEntry::make('id')
                                            ->label('Product ID'),

                                        TextEntry::make('sku')
                                            ->label('Product SKU')
                                            ->badge()
                                            ->color(fn ($state) => match (true) {
                                                str_contains($state, 'LTP') => 'success',
                                                str_contains($state, 'MSE') => 'warning',
                                                default => 'primary',
                                            }),

                                        TextEntry::make('description')
                                            ->label('Product Description'),

                                        TextEntry::make('created_at')
                                            ->label('Product Creation Date')
                                            ->date('d M Y')
                                            ->color('info'),
                                    ])
                                    ->columns(2),
                            ]),

                        Tab::make('Pricing & Stock')
                            ->icon('heroicon-o-currency-dollar')
                            ->schema([
                                Section::make('Pricing Information')
                                    ->schema([
                                        TextEntry::make('price')
                                            ->label('Price')
                                            ->weight('bold')
                                            ->color('primary')
                                            ->icon('heroicon-o-currency-dollar')
                                            ->formatStateUsing(
                                                fn ($state) => 'Rp ' . number_format($state, 0, ',', '.')
                                            ),

                                        TextEntry::make('stock')
                                            ->label('Stock')
                                            ->icon('heroicon-o-cube')
                                            ->badge()
                                            ->color(fn ($state) => match (true) {
                                                $state <= 5 => 'danger',
                                                $state <= 20 => 'warning',
                                                default => 'success',
                                            }),
                                    ])
                                    ->columns(2),
                            ]),

                        Tab::make('Media & Status')
                            ->icon('heroicon-o-photo')
                            ->schema([
                                Section::make('Media and Status')
                                    ->schema([
                                        ImageEntry::make('image')
                                            ->label('Product Image')
                                            ->disk('public'),

                                        IconEntry::make('is_active')
                                            ->label('Active Status')
                                            ->boolean(),

                                        IconEntry::make('is_featured')
                                            ->label('Featured Product')
                                            ->boolean(),
                                    ])
                                    ->columns(3),
                            ]),

                    ])
                    ->columnSpanFull(),

            ]);
    }
}