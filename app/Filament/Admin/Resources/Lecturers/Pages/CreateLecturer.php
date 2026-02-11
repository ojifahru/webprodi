<?php

namespace App\Filament\Admin\Resources\Lecturers\Pages;

use App\Filament\Admin\Resources\Lecturers\LecturerResource;
use App\Filament\Admin\Resources\Lecturers\Schemas\LecturerForm;
use App\Models\Lecturer;
use Filament\Actions\Action;
use Filament\Facades\Filament;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Text;
use Filament\Schemas\Schema;
use Filament\Support\Exceptions\Halt;
use Filament\Forms\Components\TextInput;
use Filament\Support\Facades\FilamentView;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class CreateLecturer extends CreateRecord
{
    protected static string $resource = LecturerResource::class;

    public bool $hasCheckedNidn = false;
    public ?int $foundLecturerId = null;

    protected ?Lecturer $foundLecturerCache = null;

    /* =============================
     * FORM
     * ============================= */
    public function form(Schema $schema): Schema
    {
        return $this->defaultForm($schema)->components([
            Section::make()
                ->columnSpanFull()
                ->schema([
                    Text::make(fn(): string => 'Active Study Program: ' . ($this->getTenantName() ?? '-')),
                    Text::make(fn(): string => $this->hasCheckedNidn
                        ? ('NIDN yang dicek: ' . ($this->getCheckedNidn() ?: '-'))
                        : 'NIDN belum dicek.'),
                ]),

            Section::make('Step 1 – NIDN Check')
                ->visible(fn(): bool => ! $this->hasCheckedNidn)
                ->columnSpanFull()
                ->columns(1)
                ->schema([
                    TextInput::make('nidn')
                        ->label('NIDN')
                        ->required()
                        ->maxLength(30)
                        ->live()
                        ->afterStateUpdated(function (): void {
                            $this->resetNidnCheck();
                        })
                        ->helperText('Masukkan NIDN lalu klik "Check NIDN".'),

                    Actions::make([
                        Action::make('checkNidn')
                            ->label('Check NIDN')
                            ->disabled(fn(): bool => $this->hasCheckedNidn)
                            ->action(function (): void {
                                $this->checkNidn();
                            }),
                    ])->fullWidth(),
                ]),

            Section::make('Step 2 – Lecturer Found')
                ->visible(fn(): bool => $this->hasCheckedNidn && filled($this->foundLecturerId))
                ->columnSpanFull()
                ->columns(1)
                ->schema([
                    Text::make(fn(): string => 'Nama: ' . ($this->getFoundLecturer()?->name ?? '-')),
                    Text::make(fn(): string => 'NIDN: ' . ($this->getFoundLecturer()?->nidn ?? '-')),
                    Text::make(fn(): string => 'Email: ' . ($this->getFoundLecturer()?->email ?? '-')),
                    Text::make(fn(): string => 'No. HP: ' . ($this->getFoundLecturer()?->phone ?? '-')),
                    Text::make('Dosen ini sudah terdaftar secara global. Klik tombol di bawah untuk attach ke prodi aktif.'),

                    Actions::make([
                        Action::make('attach')
                            ->label('Attach to this Study Program')
                            ->requiresConfirmation()
                            ->modalHeading('Attach dosen?')
                            ->modalDescription(fn(): string => 'Attach dosen ke ' . ($this->getTenantName() ?? 'prodi aktif') . ' sebagai secondary?')
                            ->action(function (): void {
                                $this->attachFoundLecturer();
                            }),
                    ])->fullWidth(),
                ]),

            Section::make('Step 2 – Create New Lecturer')
                ->visible(fn(): bool => $this->hasCheckedNidn && blank($this->foundLecturerId))
                ->columnSpanFull()
                ->columns(1)
                ->schema([
                    Text::make(fn(): string => 'NIDN: ' . ($this->getCheckedNidn() ?: '-'))
                        ->columnSpanFull(),

                    Text::make(fn(): string => 'Dosen ini akan dibuat dan diset sebagai PRIMARY untuk prodi aktif (' . ($this->getTenantName() ?? '-') . ').')
                        ->columnSpanFull(),

                    ...LecturerForm::fields(includeNidn: false),

                    Actions::make([
                        $this->getCreateFormAction()->label('Create Lecturer'),
                        Action::make('changeNidn')
                            ->label('Change NIDN')
                            ->color('gray')
                            ->action(function (): void {
                                $this->resetNidnCheck();
                            }),
                    ])
                        ->columnSpanFull()
                        ->fullWidth(),
                ]),

        ]);
    }

    /* =============================
     * FORM ACTIONS
     * ============================= */
    protected function getFormActions(): array
    {
        return [];
    }

    protected function getCreateFormAction(): Action
    {
        return parent::getCreateFormAction()
            ->requiresConfirmation()
            ->modalHeading('Buat dosen?')
            ->modalDescription(fn(): string => 'Buat dosen dan set sebagai PRIMARY di ' . ($this->getTenantName() ?? 'prodi aktif') . '?');
    }

    /* =============================
     * LOGIC: CEK NIDN
     * ============================= */
    public function checkNidn(): void
    {
        $this->foundLecturerCache = null;
        $nidn = trim((string) ($this->data['nidn'] ?? ''));

        $this->hasCheckedNidn = true;
        $this->foundLecturerId = null;

        if ($nidn === '') {
            Notification::make()
                ->warning()
                ->title('NIDN wajib diisi.')
                ->send();
            return;
        }

        $existingLecturer = Lecturer::where('nidn', $nidn)->first();

        if ($existingLecturer) {
            $this->foundLecturerId = $existingLecturer->getKey();
            $this->foundLecturerCache = $existingLecturer;

            Notification::make()
                ->success()
                ->title('Dosen ditemukan.')
                ->send();
            return;
        }

        Notification::make()
            ->info()
            ->title('NIDN belum terdaftar. Silakan isi data dosen baru.')
            ->send();
    }

    protected function resetNidnCheck(): void
    {
        $this->hasCheckedNidn = false;
        $this->foundLecturerId = null;
        $this->foundLecturerCache = null;
    }

    protected function getCheckedNidn(): string
    {
        return trim((string) ($this->data['nidn'] ?? ''));
    }

    protected function getTenantName(): ?string
    {
        $tenant = Filament::getTenant();

        return $tenant?->name;
    }

    protected function getFoundLecturer(): ?Lecturer
    {
        if (! $this->foundLecturerId) {
            return null;
        }

        if ($this->foundLecturerCache?->getKey() === $this->foundLecturerId) {
            return $this->foundLecturerCache;
        }

        $this->foundLecturerCache = Lecturer::find($this->foundLecturerId);

        return $this->foundLecturerCache;
    }

    /* =============================
     * LOGIC: ATTACH DOSEN
     * ============================= */
    public function attachFoundLecturer(): void
    {
        $tenant = Filament::getTenant();

        if (! $tenant) {
            Notification::make()
                ->danger()
                ->title('Tenant tidak ditemukan.')
                ->send();
            return;
        }

        $lecturer = $this->getFoundLecturer();

        if (! $lecturer) {
            Notification::make()
                ->danger()
                ->title('Dosen tidak ditemukan.')
                ->send();
            return;
        }

        if ($lecturer->studyPrograms()->whereKey($tenant->getKey())->exists()) {
            Notification::make()
                ->warning()
                ->title('Dosen sudah terdaftar di prodi ini.')
                ->send();
            return;
        }

        try {
            DB::transaction(function () use ($lecturer, $tenant): void {
                if ($lecturer->studyPrograms()->whereKey($tenant->getKey())->exists()) {
                    return;
                }

                $lecturer->studyPrograms()->syncWithoutDetaching([
                    $tenant->getKey() => ['is_primary' => false],
                ]);
            });
        } catch (QueryException) {
            Notification::make()
                ->warning()
                ->title('Lecturer already attached to this study program.')
                ->send();

            $this->redirectToIndex();

            return;
        }

        Notification::make()
            ->success()
            ->title('Lecturer attached successfully.')
            ->send();

        $this->redirectToIndex();
    }

    /* =============================
     * BEFORE CREATE
     * ============================= */
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (! $this->hasCheckedNidn) {
            Notification::make()
                ->warning()
                ->title('Silakan cek NIDN terlebih dahulu.')
                ->send();
            throw new Halt();
        }

        if (filled($this->foundLecturerId)) {
            Notification::make()
                ->warning()
                ->title('NIDN sudah terdaftar. Gunakan Attach.')
                ->send();
            throw new Halt();
        }

        $nidn = trim((string) ($this->data['nidn'] ?? ''));

        if (Lecturer::where('nidn', $nidn)->exists()) {
            Notification::make()
                ->danger()
                ->title('NIDN sudah terdaftar.')
                ->send();
            throw new Halt();
        }

        $data['nidn'] = $nidn;

        return $data;
    }

    protected function handleRecordCreation(array $data): Lecturer
    {
        $tenant = Filament::getTenant();

        if (! $tenant) {
            Notification::make()
                ->danger()
                ->title('Tenant tidak ditemukan.')
                ->send();

            throw new Halt();
        }

        $nidn = trim((string) ($data['nidn'] ?? ''));

        try {
            /** @var Lecturer $lecturer */
            $lecturer = DB::transaction(function () use ($data, $tenant, $nidn): Lecturer {
                if (Lecturer::where('nidn', $nidn)->exists()) {
                    Notification::make()
                        ->danger()
                        ->title('NIDN sudah terdaftar.')
                        ->send();

                    throw new Halt();
                }

                /** @var Lecturer $created */
                $created = static::getModel()::create($data);

                $created->studyPrograms()->syncWithoutDetaching([
                    $tenant->getKey() => ['is_primary' => true],
                ]);

                return $created;
            });
        } catch (QueryException) {
            Notification::make()
                ->danger()
                ->title('Failed to create lecturer. NIDN may already exist.')
                ->send();

            throw new Halt();
        }

        return $lecturer;
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        $tenantName = $this->getTenantName();

        if (! $tenantName) {
            return 'Lecturer created.';
        }

        return 'Lecturer created and set as PRIMARY in ' . $tenantName . '.';
    }

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl();
    }

    protected function redirectToIndex(): void
    {
        $url = $this->getRedirectUrl();
        $this->redirect($url, navigate: FilamentView::hasSpaMode($url));
    }
}
