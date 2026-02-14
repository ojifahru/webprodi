<?php

namespace App\Filament\Resources\Lecturers\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class LecturerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->schema(
            Section::make('Lecturer Details')
                ->columnSpanFull()
                ->columns(2)
                ->schema([
                    TextInput::make('name')
                        ->required(),
                    TextInput::make('nidn')
                        ->required(),
                    TextInput::make('email')
                        ->label('Email address')
                        ->email()
                        ->required(),
                    TextInput::make('phone')
                        ->tel()
                        ->default(null),
                    Textarea::make('bio')
                        ->default(null)
                        ->columnSpanFull(),
                    FileUpload::make('photo_path')
                        ->label('Photo')
                        ->image()
                        ->maxSize(2048)
                        ->disk('public')
                        ->directory('lecturer-photos')
                        ->columnSpanFull(),
                    Select::make('study_programs')
                        ->label('Study Programs')
                        ->multiple()
                        ->relationship('studyPrograms', 'name')
                        ->preload()
                        ->required(),
                ]),
        );
    }
}
