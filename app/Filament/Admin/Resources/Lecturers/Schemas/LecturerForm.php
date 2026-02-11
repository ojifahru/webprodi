<?php

namespace App\Filament\Admin\Resources\Lecturers\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;

class LecturerForm
{
    /**
     * @return array<\Filament\Schemas\Components\Component>
     */
    public static function components(bool $includeNidn = true): array
    {
        return [
            Section::make()
                ->label('Data Dosen')
                ->columns([
                    'default' => 1,
                    'md' => 2,
                ])
                ->columnSpanFull()
                ->schema(static::fields($includeNidn)),
        ];
    }

    /**
     * @return array<\Filament\Schemas\Components\Component>
     */
    public static function fields(bool $includeNidn = true): array
    {
        $fields = [
            TextInput::make('name')
                ->label('Nama Dosen')
                ->required()
                ->maxLength(150),
        ];

        if ($includeNidn) {
            $fields[] = TextInput::make('nidn')
                ->label('NIDN')
                ->required()
                ->maxLength(30);
        }

        return [
            ...$fields,

            TextInput::make('email')
                ->label('Email')
                ->email()
                ->required()
                ->maxLength(150)
                ->unique(ignoreRecord: true),

            TextInput::make('phone')
                ->label('No. HP')
                ->tel()
                ->nullable()
                ->maxLength(30),

            Textarea::make('bio')
                ->label('Biografi')
                ->rows(5)
                ->nullable()
                ->columnSpanFull(),

            FileUpload::make('photo_path')
                ->label('Foto Dosen')
                ->image()
                ->disk('public')
                ->directory('lecturers')
                ->visibility('public')
                ->imageEditor()
                ->maxSize(2048)
                ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                ->nullable()
                ->columnSpanFull(),
        ];
    }

    public static function configure(Schema $schema, bool $includeNidn = true): Schema
    {
        return $schema->components(static::components($includeNidn));
    }
}
