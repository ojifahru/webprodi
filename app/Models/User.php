<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasTenants;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class User extends Authenticatable implements FilamentUser, HasTenants
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, LogsActivity, Notifiable;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'name',
                'email',
                'is_superadmin',
            ])
            ->logOnlyDirty()
            ->useLogName('user')
            ->setDescriptionForEvent(fn (string $eventName) => "User has been {$eventName}");
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_superadmin',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'is_superadmin' => 'boolean',
            'password' => 'hashed',
        ];
    }

    public function studyPrograms(): BelongsToMany
    {
        return $this->belongsToMany(StudyProgram::class, 'admin_study_program', 'user_id', 'study_program_id');
    }

    public function getTenants(Panel $panel): Collection
    {
        if ($this->isSuperadmin()) {
            return StudyProgram::all();
        }

        return $this->studyPrograms()
            ->where('is_active', true)
            ->get();
    }

    public function canAccessTenant(Model $tenant): bool
    {
        if ($this->isSuperadmin()) {
            return true;
        }

        if (($tenant instanceof StudyProgram) && (! $tenant->is_active)) {
            return false;
        }

        return $this->studyPrograms()
            ->where('is_active', true)
            ->whereKey($tenant)
            ->exists();
    }

    public function isSuperadmin(): bool
    {
        return $this->is_superadmin;
    }

    public function canAccessPanel(Panel $panel): bool
    {
        if ($this->isSuperadmin()) {
            return true;
        }

        return $panel->getId() === 'admin';
    }

    // Tenant access check can be implemented here if needed

}
