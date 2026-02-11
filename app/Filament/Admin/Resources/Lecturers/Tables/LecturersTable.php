<?php

namespace App\Filament\Admin\Resources\Lecturers\Tables;

use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Facades\Filament;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class LecturersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('photo_path')
                    ->label('Foto')
                    ->circular()
                    ->size(40)
                    ->defaultImageUrl(url('/images/avatar-placeholder.png')),

                TextColumn::make('name')
                    ->label('Nama')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('nidn')
                    ->label('NIDN')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('phone')
                    ->label('No. HP')
                    ->toggleable(),

                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->recordActions([
                EditAction::make(),
                Action::make('detach')
                    ->label('Detach')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->modalHeading('Detach dosen?')
                    ->modalDescription('Dosen akan dilepas dari prodi (tenant) saat ini. Data dosen tidak akan dihapus.')
                    ->disabled(function ($record): bool {
                        $tenant = Filament::getTenant();

                        if (! $tenant) {
                            return true;
                        }

                        $studyProgram = $record->studyPrograms()
                            ->whereKey($tenant->getKey())
                            ->first();

                        return (bool) ($studyProgram?->pivot?->is_primary ?? false);
                    })
                    // ->helperText('Homebase tidak bisa di-detach. Pindahkan homebase dulu jika perlu.')
                    ->action(function ($record): void {
                        $tenant = Filament::getTenant();

                        if (! $tenant) {
                            Notification::make()
                                ->danger()
                                ->title('Tenant tidak ditemukan.')
                                ->send();

                            return;
                        }

                        $record->studyPrograms()->detach($tenant->getKey());

                        Notification::make()
                            ->success()
                            ->title('Dosen berhasil di-detach dari prodi saat ini.')
                            ->send();
                    }),
            ])
            ->toolbarActions([
                // ❌ Tidak ada bulk delete untuk admin prodi
            ]);
    }
}
