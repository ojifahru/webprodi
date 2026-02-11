<?php

namespace App\Filament\Resources\StudyPrograms\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

class StudyProgramForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Tabs::make('Profil Program Studi')
                ->columnSpanFull()
                ->tabs([
                    /* =========================
                     * IDENTITAS PROGRAM STUDI
                     * ========================= */
                    Tab::make('Identitas')
                        ->icon('heroicon-o-identification')
                        ->columns(2)
                        ->components([
                            TextInput::make('name')
                                ->label('Nama Program Studi')
                                ->required(),

                            TextInput::make('code')
                                ->label('Kode Program Studi')
                                ->required(),

                            TextInput::make('domain')
                                ->label('Domain Program Studi')
                                ->required()
                                ->helperText('Contoh: informatika.univbatam.ac.id')
                                ->columnSpanFull(),
                        ]),
                    /* =========================
                     * AKADEMIK & AKREDITASI
                     * ========================= */
                    Tab::make('Akademik')
                        ->icon('heroicon-o-academic-cap')
                        ->columns(2)
                        ->components([
                            Textarea::make('description')
                                ->label('Deskripsi Singkat')
                                ->rows(3)
                                ->columnSpanFull(),
                            TextInput::make('faculty')
                                ->label('Fakultas'),

                            Select::make('degree_level')
                                ->label('Jenjang')
                                ->options([
                                    'D3' => 'D3',
                                    'S1' => 'S1',
                                    'S2' => 'S2',
                                    'S3' => 'S3',
                                ]),

                            TextInput::make('accreditation')
                                ->label('Status Akreditasi')
                                ->placeholder('Unggul / A / Baik Sekali'),

                            TextInput::make('established_year')
                                ->label('Tahun Berdiri')
                                ->numeric()
                                ->minValue(1900)
                                ->maxValue(now()->year),

                            FileUpload::make('accreditation_file_path')
                                ->label('File Akreditasi (PDF)')
                                ->disk('public')
                                ->directory('accreditations')
                                ->acceptedFileTypes(['application/pdf']),
                        ]),

                    /* =========================
                     * KONTAK & BRANDING
                     * ========================= */
                    Tab::make('Kontak & Branding')
                        ->icon('heroicon-o-phone')
                        ->columns(2)
                        ->components([
                            FileUpload::make('logo_path')
                                ->label('Logo')
                                ->disk('public')
                                ->directory('logos')
                                ->image()
                                ->columnSpanFull(),
                            FileUpload::make('favicon_path')
                                ->label('Favicon')
                                ->disk('public')
                                ->directory('favicons')
                                ->image(),
                            FileUpload::make('banner_path')
                                ->label('Banner')
                                ->disk('public')
                                ->directory('banners')
                                ->image(),

                            TextInput::make('email')
                                ->email(),

                            TextInput::make('phone'),

                            Textarea::make('address')
                                ->columnSpanFull(),
                        ]),

                    /* =========================
                     * VISI, MISI & TUJUAN
                     * ========================= */
                    Tab::make('Visi & Misi')
                        ->icon('heroicon-o-light-bulb')
                        ->components([
                            Textarea::make('vision')
                                ->label('Visi')
                                ->rows(3),

                            Textarea::make('mission')
                                ->label('Misi')
                                ->rows(4),

                            Textarea::make('objectives')
                                ->label('Tujuan Program Studi')
                                ->rows(4),
                        ]),

                    /* =========================
                     * PROFIL LENGKAP
                     * ========================= */
                    Tab::make('Profil')
                        ->icon('heroicon-o-document-text')
                        ->components([
                            Textarea::make('about')
                                ->label('Tentang Program Studi')
                                ->rows(6),
                        ]),

                    /* =========================
                     * MEDIA SOSIAL
                     * ========================= */
                    Tab::make('Media Sosial')
                        ->icon('heroicon-o-share')
                        ->columns(2)
                        ->components([
                            TextInput::make('facebook_link')->label('Facebook'),
                            TextInput::make('instagram_link')->label('Instagram'),
                            TextInput::make('twitter_link')->label('Twitter'),
                            TextInput::make('linkedin_link')->label('LinkedIn'),
                            TextInput::make('youtube_link')->label('YouTube'),
                        ]),

                    /* =========================
                     * SEO
                     * ========================= */
                    Tab::make('SEO')
                        ->icon('heroicon-o-magnifying-glass')
                        ->components([
                            TextInput::make('meta_title')
                                ->label('Meta Title')
                                ->maxLength(60),

                            Textarea::make('meta_description')
                                ->label('Meta Description')
                                ->rows(3),

                            TextInput::make('meta_keywords')
                                ->label('Meta Keywords'),
                        ]),
                ]),
        ]);
    }
}
