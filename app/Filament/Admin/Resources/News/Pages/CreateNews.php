<?php

namespace App\Filament\Admin\Resources\News\Pages;

use App\Filament\Admin\Resources\News\NewsResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateNews extends CreateRecord
{
    protected static string $resource = NewsResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if ($tenant = filament()->getTenant()) {
            $data['study_program_id'] = $tenant->getKey();
        }

        $data['author_id'] = Auth::id();

        return $data;
    }
}
