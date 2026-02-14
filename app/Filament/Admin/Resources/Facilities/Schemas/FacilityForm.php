<?php

namespace App\Filament\Admin\Resources\Facilities\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class FacilityForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->schema(
            Section::make('Informasi Fasilitas')
                ->schema([
                    TextInput::make('name')
                        ->label('Nama Fasilitas')
                        ->required()
                        ->live(onBlur: true)
                        ->afterStateUpdated(fn(Set $set, ?string $state) => $set('slug', Str::slug($state))),
                    TextInput::make('slug')
                        ->required()
                        ->unique(
                            table: 'facilities',
                            column: 'slug',
                            ignoreRecord: true,
                        )
                        ->afterStateUpdated(
                            fn($state, callable $set, callable $get) => filled($state) && blank($get('slug'))
                                ? $set('slug', Str::slug($state))
                                : null
                        ),
                    RichEditor::make('description')
                        ->label('Deskripsi Fasilitas')
                        ->fileAttachmentsDisk('public')
                        ->fileAttachmentsDirectory('facilities/descriptions')
                        ->fileAttachmentsVisibility('public')
                        ->fileAttachmentsAcceptedFileTypes(['image/jpeg', 'image/png'])
                        ->fileAttachmentsMaxSize(5120)
                        ->resizableImages()
                        ->columnSpanFull(),
                    Toggle::make('is_featured')
                        ->label('Tampilkan di Beranda')
                        ->helperText('Aktifkan untuk menampilkan fasilitas ini di bagian beranda.'),

                    FileUpload::make('image_path')
                        ->label('Gambar Fasilitas')
                        ->disk('public')
                        ->directory('facilities/images')
                        ->visibility('public')
                        ->acceptedFileTypes(['image/jpeg', 'image/png'])
                        ->maxSize(5120),

                ])
                ->columns(2)
                ->columnSpanFull()
        );
    }
}
