<?php

namespace App\Providers;

use App\Models\StudyProgram;
use App\Models\User as AppUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class TenantServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Jangan resolve tenant di console / artisan
        if ($this->app->runningInConsole()) {
            return;
        }

        $host = $this->normalizeHost(request()->getHost());
        $excludedPanelHosts = array_filter([
            $this->normalizeHost((string) config('app.admin_app_url')),
            $this->normalizeHost((string) config('app.superadmin_app_url')),
        ]);

        if (in_array($host, $excludedPanelHosts, true)) {
            return;
        }

        // Cari tenant berdasarkan domain.
        // Jika tenant tidak aktif, hanya superadmin yang boleh mengaksesnya.
        $tenant = StudyProgram::query()
            ->where('domain', $host)
            ->first();

        if (! $tenant) {
            abort(404);
        }

        // Simpan tenant ke container
        $this->app->instance('currentTenant', $tenant);

        // Share ke semua view
        View::share('tenant', $tenant);

        if (! $tenant->is_active) {
            $user = Auth::user();

            if (! ($user instanceof AppUser) || (! $user->isSuperadmin())) {
                abort(503);
            }
        }
    }

    protected function normalizeHost(?string $host): ?string
    {
        if (! is_string($host) || trim($host) === '') {
            return null;
        }

        $host = trim($host);
        $hostWithScheme = str_contains($host, '://') ? $host : 'http://' . $host;
        $parsedHost = parse_url($hostWithScheme, PHP_URL_HOST);
        $normalizedHost = is_string($parsedHost) && $parsedHost !== '' ? $parsedHost : $host;
        $normalizedHost = preg_replace('/^www\./i', '', strtolower($normalizedHost));

        return is_string($normalizedHost) && $normalizedHost !== '' ? $normalizedHost : null;
    }
}
