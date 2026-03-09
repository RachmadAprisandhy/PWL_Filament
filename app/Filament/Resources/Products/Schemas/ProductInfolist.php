<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Schemas\Components\Section;
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
                Section::make('Product Info')
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
                    ->columnSpanFull(),

                Section::make('Product Prices and Stock')
                    ->schema([
                        TextEntry::make('price')
                            ->label('Price')
                            ->weight('bold')
                            ->color('primary')
                            ->icon('heroicon-o-currency-dollar')
                            ->formatStateUsing(fn ($state) => 'Rp ' . number_format($state, 0, ',', '.')),

                        TextEntry::make('stock')
                            ->label('Stock')
                            ->icon('heroicon-o-cube'),
                    ])
                    ->columnSpanFull(),

                Section::make('Media dan Status')
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
                    ->columnSpanFull(),
            ]);
    }
}