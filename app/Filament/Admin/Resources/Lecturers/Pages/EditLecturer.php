<?php

namespace App\Filament\Admin\Resources\Lecturers\Pages;

use App\Filament\Admin\Resources\Lecturers\LecturerResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditLecturer extends EditRecord
{
    protected static string $resource = LecturerResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Contoh normalisasi (opsional)
        if (isset($data['nidn'])) {
            $data['nidn'] = trim($data['nidn']);
        }

        return $data;
    }

    /**
     * Pastikan dosen tetap attached ke prodi aktif
     */
    protected function afterSave(): void
    {
        $tenant = Filament::getTenant();

        if (! $tenant) {
            return;
        }

        // Jangan detach relasi lain, hanya pastikan relasi prodi aktif ada
        $this->record->studyPrograms()->syncWithoutDetaching([
            $tenant->id,
        ]);
    }
}
