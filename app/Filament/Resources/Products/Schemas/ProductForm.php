<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Wizard;
use Filament\Schemas\Components\Wizard\Step;
use Filament\Schemas\Components\Group;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\TextInput;
use Filament\Actions\Action;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Wizard::make([

                    Step::make('Product Info')
                        ->icon('heroicon-o-information-circle')
                        ->description('Isi Informasi Produk')
                        ->schema([

                            Group::make([
                                TextInput::make('name')
                                    ->label('Product Name')
                                    ->placeholder('Masukkan nama produk')
                                    ->required()
                                    ->maxLength(100),

                                TextInput::make('sku')
                                    ->label('SKU')
                                    ->placeholder('Contoh: LTP001')
                                    ->required()
                                    ->unique(ignoreRecord: true),
                            ])->columns(2),

                            MarkdownEditor::make('description')
                                ->label('Product Description')
                                ->placeholder('Tulis deskripsi produk disini'),
                        ]),

                    Step::make('Product Prices and Stock')
                        ->icon('heroicon-o-currency-dollar')
                        ->description('Isi Harga dan Stok Produk')
                        ->schema([

                            Group::make([
                                TextInput::make('price')
                                    ->label('Price')
                                    ->numeric()
                                    ->required()
                                    ->minValue(1)
                                    ->prefix('Rp')
                                    ->placeholder('500000'),

                                TextInput::make('stock')
                                    ->label('Stock')
                                    ->numeric()
                                    ->required()
                                    ->minValue(0)
                                    ->placeholder('10'),
                            ])->columns(2),

                        ]),

                    Step::make('Media dan Status')
                        ->icon('heroicon-o-photo')
                        ->description('Upload gambar produk dan status')
                        ->schema([

                            FileUpload::make('image')
                                ->label('Product Image')
                                ->image()
                                ->disk('public')
                                ->directory('products')
                                ->imagePreviewHeight('200')
                                ->maxSize(2048),

                            Checkbox::make('is_active')
                                ->label('Product Active')
                                ->default(true),

                            Checkbox::make('is_featured')
                                ->label('Featured Product')
                                ->default(false),
                        ]),

                ])
                    ->columnSpanFull()
                    ->submitAction(
                        Action::make('save')
                            ->label('Simpan Produk')
                            ->button()
                            ->color('primary')
                            ->submit('save')
                    ),
            ]);
    }
}