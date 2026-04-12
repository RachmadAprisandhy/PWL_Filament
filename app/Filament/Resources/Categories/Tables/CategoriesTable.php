<?php

namespace App\Filament\Resources\Categories\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\DeleteAction;


class CategoriesTable
{
  public static function configure(Table $table): Table
{
    return $table
        ->columns([
            TextColumn::make('name')
                ->label('Category Name')
                ->searchable()
                ->sortable()
                ->weight('bold') // lebih tebal
                ->color('primary') // warna Tailwind (biru default)
                ->icon('heroicon-o-tag'),

            TextColumn::make('slug')
                ->label('Slug')
                ->searchable()
                ->badge() // jadi badge
                ->color('gray') // warna badge
                ->icon('heroicon-o-link'),
        ])
        ->striped() // baris belang (biar ga flat)
        ->defaultSort('created_at', 'desc') // sorting default
        ->recordActions([
            EditAction::make()
                ->color('warning')
                ->icon('heroicon-o-pencil-square'),

            DeleteAction::make()
                ->color('danger')
                ->icon('heroicon-o-trash'),
        ])
        ->toolbarActions([
            BulkActionGroup::make([
                DeleteBulkAction::make(),
            ]),
        ])
        ->emptyStateHeading('Belum ada kategori 😢')
        ->emptyStateDescription('Silakan tambahkan kategori baru.')
        ->emptyStateIcon('heroicon-o-folder-open');
}
}
