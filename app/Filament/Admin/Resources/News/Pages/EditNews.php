<?php

namespace App\Filament\Admin\Resources\News\Pages;

use App\Filament\Admin\Resources\News\NewsResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditNews extends EditRecord
{
    protected static string $resource = NewsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function authorizeAccess(): void
    {
        $tenant = filament()->getTenant();

        abort_if(
            $tenant && $this->record->study_program_id !== $tenant->getKey(),
            403
        );
    }
}
