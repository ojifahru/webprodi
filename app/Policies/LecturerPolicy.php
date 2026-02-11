<?php

namespace App\Policies;

use App\Models\Lecturer;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Filament\Facades\Filament;

class LecturerPolicy
{
    protected function isSuperAdmin(User $user): bool
    {
        return (bool) $user->is_superadmin;
    }
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Lecturer $lecturer): bool
    {
        if ($this->isSuperAdmin($user)) {
            return true;
        }

        $tenant = Filament::getTenant();

        return $lecturer->studyPrograms()
            ->where('study_program_id', $tenant?->id)
            ->exists();
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Lecturer $lecturer): bool
    {
        if ($this->isSuperAdmin($user)) {
            return true;
        }

        $tenant = Filament::getTenant();

        return $lecturer->studyPrograms()
            ->where('study_program_id', $tenant?->id)
            ->exists();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Lecturer $lecturer): bool
    {
        return $this->isSuperAdmin($user);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Lecturer $lecturer): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Lecturer $lecturer): bool
    {
        return false;
    }
}
