<?php

namespace App\Filament\Resources\Lecturers\Tables;

use App\Models\StudyProgram;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
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
                    ->disk('public')
                    ->circular()
                    ->size(40),

                TextColumn::make('name')
                    ->label('Nama')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('nidn')
                    ->label('NIDN')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('studyPrograms.name')
                    ->label('Program Studi')
                    ->badge()
                    ->separator(', ')
                    ->toggleable(),
            ])
            ->recordActions([
                EditAction::make(),

                // 🟢 Attach manual ke prodi
                Action::make('attach')
                    ->label('Attach ke Prodi')
                    ->icon('heroicon-o-link')
                    ->color('primary')
                    ->form([
                        \Filament\Forms\Components\Select::make('study_program_id')
                            ->label('Program Studi')
                            ->options(
                                StudyProgram::query()->pluck('name', 'id')
                            )
                            ->searchable()
                            ->required(),
                    ])
                    ->action(function ($record, array $data) {
                        $record->studyPrograms()->syncWithoutDetaching([
                            $data['study_program_id'] => ['is_primary' => false],
                        ]);
                    }),

                // ⭐ Jadikan Homebase
                Action::make('homebase')
                    ->label('Jadikan Homebase')
                    ->icon('heroicon-o-star')
                    ->color('warning')
                    ->form([
                        \Filament\Forms\Components\Select::make('study_program_id')
                            ->label('Program Studi')
                            ->options(
                                fn($record) =>
                                $record->studyPrograms->pluck('name', 'id')
                            )
                            ->required(),
                    ])
                    ->requiresConfirmation()
                    ->action(function ($record, array $data) {
                        // reset semua
                        $record->studyPrograms()->updateExistingPivot(
                            $record->studyPrograms->pluck('id')->toArray(),
                            ['is_primary' => false]
                        );

                        // set homebase baru
                        $record->studyPrograms()->updateExistingPivot(
                            $data['study_program_id'],
                            ['is_primary' => true]
                        );
                    }),
                Action::make('detach')
                    ->label('Detach Prodi')
                    ->icon('heroicon-o-trash')
                    ->color('danger')
                    ->visible(fn() => auth()->user()->is_superadmin)
                    ->requiresConfirmation()
                    ->form([
                        Select::make('study_program_id')
                            ->label('Program Studi')
                            ->options(
                                fn($record) =>
                                // HANYA prodi yang BUKAN homebase
                                $record->studyPrograms
                                    ->where('pivot.is_primary', false)
                                    ->pluck('name', 'id')
                            )
                            ->helperText('Homebase tidak bisa di-detach. Pindahkan homebase dulu jika perlu.')
                            ->required(),
                    ])
                    ->action(function ($record, array $data) {
                        $studyProgramId = $data['study_program_id'];

                        // Safety: jangan detach kalau cuma tersisa 1 prodi
                        if ($record->studyPrograms()->count() <= 1) {
                            throw new \RuntimeException('Dosen harus terhubung minimal ke satu Program Studi.');
                        }

                        // Detach aman
                        $record->studyPrograms()->detach($studyProgramId);
                    }),

            ]);
    }
}
