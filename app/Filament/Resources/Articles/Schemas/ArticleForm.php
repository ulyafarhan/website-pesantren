<?php

namespace App\Filament\Resources\Articles\Schemas;

use App\Models\Article;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Hidden;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Facades\Filament;

class ArticleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(3)
                    ->schema([
                        Section::make('Konten Artikel')
                            ->description('Kelola isi utama berita atau artikel pesantren.')
                            ->schema([
                                TextInput::make('title')
                                    ->label('Judul')
                                    ->required()
                                    ->maxLength(255)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn (string $state, Set $set) => $set('slug', Str::slug($state))),
                                
                                TextInput::make('slug')
                                    ->label('Slug URL')
                                    ->required()
                                    ->maxLength(255)
                                    ->unique(Article::class, 'slug', ignoreRecord: true),
                                
                                Textarea::make('excerpt')
                                    ->label('Kutipan Singkat')
                                    ->required()
                                    ->rows(3)
                                    ->columnSpanFull(),
                                
                                RichEditor::make('content')
                                    ->label('Isi Artikel')
                                    ->required()
                                    ->columnSpanFull()
                                    ->fileAttachmentsDirectory('articles/attachments'),
                            ])
                            ->columnSpan(2),

                        Section::make('Publikasi')
                            ->description('Pengaturan status dan media.')
                            ->schema([
                                FileUpload::make('cover_image')
                                    ->label('Gambar Sampul')
                                    ->image()
                                    ->directory('articles/covers')
                                    ->imageEditor(),
                                
                                Toggle::make('is_published')
                                    ->label('Terbitkan')
                                    ->default(false)
                                    ->required(),
                                
                                DateTimePicker::make('published_at')
                                    ->label('Jadwal Tayang')
                                    ->default(now()),

                                Hidden::make('author_id')
                                    ->default(fn () => Filament::auth()->id()),
                            ])
                            ->columnSpan(1),
                    ]),
            ]);
    }
}