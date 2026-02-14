<?php

namespace App\Filament\Admin\Resources\News\Schemas;

use Filament\Facades\Filament;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class NewsForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Tabs::make('News Tabs')
                ->columnSpanFull()
                ->tabs([

                    /* =====================
                     * TAB 1: KONTEN
                     * ===================== */
                    Tabs\Tab::make('Konten')
                        ->icon('heroicon-o-document-text')
                        ->schema([
                            TextInput::make('title')
                                ->label('Judul')
                                ->required()
                                ->live(onBlur: true)
                                ->afterStateUpdated(
                                    fn($state, callable $set, callable $get) => filled($state) && blank($get('slug'))
                                        ? $set('slug', Str::slug($state))
                                        : null
                                ),

                            TextInput::make('slug')
                                ->required()
                                ->unique(
                                    table: 'news',
                                    column: 'slug',
                                    ignoreRecord: true,
                                    modifyRuleUsing: fn($rule) => $rule->where(
                                        'study_program_id',
                                        Filament::getTenant()?->getKey()
                                    )
                                ),

                            RichEditor::make('content')
                                ->label('Konten Berita')
                                ->required()
                                ->fileAttachmentsDisk('public')
                                ->fileAttachmentsDirectory('news/content')
                                ->fileAttachmentsVisibility('public')
                                ->fileAttachmentsAcceptedFileTypes(['image/jpeg', 'image/png'])
                                ->fileAttachmentsMaxSize(5120)
                                ->resizableImages()
                                ->columnSpanFull(),
                        ]),

                    /* =====================
                     * TAB 2: METADATA
                     * ===================== */
                    Tabs\Tab::make('Metadata')
                        ->icon('heroicon-o-tag')
                        ->schema([
                            Select::make('category_id')
                                ->label('Kategori')
                                ->relationship(
                                    'category',
                                    'name',
                                    modifyQueryUsing: fn($query) => $query->where(
                                        'study_program_id',
                                        Filament::getTenant()?->getKey()
                                    )
                                )
                                ->searchable()
                                ->preload()
                                ->required(),

                            Select::make('tags')
                                ->label('Tags')
                                ->multiple()
                                ->relationship(
                                    'tags',
                                    'name',
                                    modifyQueryUsing: fn($query) => $query->where(
                                        'study_program_id',
                                        Filament::getTenant()?->getKey()
                                    )
                                )
                                ->preload()
                                ->searchable(),

                            Select::make('status')
                                ->options([
                                    'draft' => 'Draft',
                                    'published' => 'Published',
                                ])
                                ->default('draft')
                                ->required()
                                ->live()
                                ->afterStateUpdated(function ($state, callable $set, callable $get): void {
                                    if ($state === 'published') {
                                        if (blank($get('published_at'))) {
                                            $set('published_at', now());
                                        }

                                        return;
                                    }

                                    $set('published_at', null);
                                }),

                            DateTimePicker::make('published_at')
                                ->label('Tanggal Publikasi')
                                ->visible(fn($get) => $get('status') === 'published')
                                ->required(fn($get) => $get('status') === 'published')
                                ->default(null),
                        ]),

                    /* =====================
                     * TAB 3: MEDIA
                     * ===================== */
                    Tabs\Tab::make('Media')
                        ->icon('heroicon-o-photo')
                        ->schema([
                            FileUpload::make('featured_image')
                                ->label('Gambar Utama')
                                ->helperText('Rekomendasi: rasio 16:9, minimal 1600×900 px (ideal 1920×1080). Gunakan JPG untuk foto agar ukuran file tetap kecil.')
                                ->image()
                                ->disk('public')
                                ->directory('news')
                                ->visibility('public')
                                ->maxSize(5120)
                                ->acceptedFileTypes(['image/jpeg', 'image/png']),
                        ]),
                ]),
        ]);
    }
}
