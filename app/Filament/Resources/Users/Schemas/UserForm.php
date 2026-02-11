<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->schema([
            Section::make('Profil Pengguna')
                ->columns(2)
                ->schema([
                    TextInput::make('name')
                        ->label('Full Name')
                        ->maxLength(255)
                        ->required(),

                    TextInput::make('email')
                        ->label('Email address')
                        ->email()
                        ->placeholder('contoh@univbatam.ac.id')
                        ->unique(ignoreRecord: true)
                        ->maxLength(255)
                        ->required(),

                    TextInput::make('password')
                        ->password()
                        ->columnSpanFull()
                        ->required(fn (string $operation): bool => $operation === 'create')
                        ->confirmed()
                        ->dehydrated(fn (?string $state): bool => filled($state))
                        ->helperText(
                            fn (string $operation) => $operation === 'edit'
                                ? 'Kosongkan jika tidak ingin mengubah password.'
                                : null
                        )
                        ->suffixAction(
                            Action::make('generatePassword')
                                ->icon('heroicon-o-key')
                                ->tooltip('Generate Password')
                                ->action(function ($set) {
                                    $password = Str::random(12);

                                    // set password
                                    $set('password', $password);
                                })
                        )
                        ->minLength(8)
                        ->autocomplete('new-password')
                        ->revealable(),

                    TextInput::make('password_confirmation')
                        ->password()
                        ->label('Confirm Password')
                        ->columnSpanFull()
                        ->required(fn (string $operation): bool => $operation === 'create')
                        ->dehydrated(false)
                        ->minLength(8)
                        ->autocomplete('new-password')
                        ->revealable(),

                    Toggle::make('is_superadmin')
                        ->label('Superadmin')
                        ->helperText('Memberikan akses penuh ke seluruh sistem.')
                        ->default(false)
                        ->inline(false)
                        ->onColor('danger')
                        ->visible(fn () => auth()->user()?->is_superadmin),
                ]),
        ]);
    }
}
