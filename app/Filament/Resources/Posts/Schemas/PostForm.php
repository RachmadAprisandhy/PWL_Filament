<?php

namespace App\Filament\Resources\Posts\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\Column;
use Filament\Schemas\Components\Section;
use Filament\Support\Icons\Heroicons;
use Filament\Schemas\Components\Group;


class PostForm
{
   public static function configure(Schema $schema): Schema
{
    return $schema
        ->columns(3)
        ->components([
            
            Section::make('Post Details')
                ->description('Fill the details of the post')
                ->icon('heroicon-o-document-text')
                ->schema([
                    Group::make([
                        TextInput::make('title')
                            ->required()
                            ->minLength(5) 
                            ->validationMessages([
                                'min' => 'Judul terlalu pendek, minimal 5 karakter ya!',
                            ]),
                            
                        TextInput::make('slug')
                            ->required()
                            ->minLength(3)
                            ->unique(table: 'posts', column: 'slug') 
                            ->validationMessages([
                                'unique' => 'Slug ini sudah dipakai, coba yang lain.',
                            ]),
                            
                        Select::make('category_id')
                            ->relationship('category', 'name')
                            ->required()
                            ->preload()
                            ->searchable(),
                            
                        ColorPicker::make('color'),
                    ])->columns(2),
                    
                    MarkdownEditor::make('content'),
                ])->columnSpan(2), 

            Group::make()
                ->schema([
                    Section::make("Image Upload")
                        ->icon('heroicon-o-photo')
                        ->schema([
                            FileUpload::make('image')
                                ->image()
                                ->required() 
                                ->disk('public')
                                ->directory('posts')
                                ->visibility('public'),
                        ]),
                    
                    Section::make("Meta Information")
                        ->icon('heroicon-o-identification')
                        ->schema([
                            TagsInput::make('tags'),
                            Checkbox::make('published'),
                            DatePicker::make('published_at'),
                        ]),
                ])
                ->columnSpan(1), 
        ]);
}
}