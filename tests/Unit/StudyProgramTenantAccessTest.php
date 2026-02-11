<?php

use App\Models\StudyProgram;
use App\Models\User;
use Filament\Panel;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(Tests\TestCase::class, RefreshDatabase::class);

it('includes inactive study programs in superadmin tenant list', function () {
    $user = User::factory()->create([
        'is_superadmin' => true,
    ]);

    $active = StudyProgram::query()->create([
        'name' => 'Active Program',
        'code' => 'ACTIVE',
        'domain' => 'active.test',
        'is_active' => true,
    ]);

    $inactive = StudyProgram::query()->create([
        'name' => 'Inactive Program',
        'code' => 'INACTIVE',
        'domain' => 'inactive.test',
        'is_active' => false,
    ]);

    $panel = \Mockery::mock(Panel::class);

    $tenants = $user->getTenants($panel);

    expect($tenants->pluck('id'))
        ->toContain($active->id)
        ->toContain($inactive->id);
});

it('filters inactive study programs from user tenant list', function () {
    $user = User::factory()->create([
        'is_superadmin' => false,
    ]);

    $active = StudyProgram::query()->create([
        'name' => 'Active Program',
        'code' => 'ACTIVE2',
        'domain' => 'active2.test',
        'is_active' => true,
    ]);

    $inactive = StudyProgram::query()->create([
        'name' => 'Inactive Program',
        'code' => 'INACTIVE2',
        'domain' => 'inactive2.test',
        'is_active' => false,
    ]);

    $user->studyPrograms()->attach([$active->id, $inactive->id]);

    $panel = \Mockery::mock(Panel::class);

    $tenants = $user->getTenants($panel);

    expect($tenants->pluck('id'))
        ->toContain($active->id)
        ->not->toContain($inactive->id);
});

it('allows superadmin to access inactive tenant', function () {
    $user = User::factory()->create([
        'is_superadmin' => true,
    ]);

    $inactive = StudyProgram::query()->create([
        'name' => 'Inactive Program',
        'code' => 'INACTIVE3',
        'domain' => 'inactive3.test',
        'is_active' => false,
    ]);

    expect($user->canAccessTenant($inactive))->toBeTrue();
});
