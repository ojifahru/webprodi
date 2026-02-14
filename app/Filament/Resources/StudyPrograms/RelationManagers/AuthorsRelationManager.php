<?php

namespace App\Filament\Resources\StudyPrograms\RelationManagers;

use Filament\Actions\AttachAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DetachAction;
use Filament\Actions\DetachBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Actions\Action;


class AdminsRelationManager extends RelationManager
{
    protected static string $relationship = 'admin';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
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
                    ->required(fn(string $operation): bool => $operation === 'create')
                    ->confirmed()
                    ->dehydrated(fn(?string $state): bool => filled($state))
                    ->helperText(
                        fn(string $operation) => $operation === 'edit'
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
                    ->required(fn(string $operation): bool => $operation === 'create')
                    ->dehydrated(false)
                    ->minLength(8)
                    ->autocomplete('new-password')
                    ->revealable(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('email')
                    ->label('Email address')
                    ->searchable(),
                TextColumn::make('email_verified_at')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make(),
                AttachAction::make(),
            ])
            ->recordActions([
                EditAction::make(),
                DetachAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DetachBulkAction::make(),
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
