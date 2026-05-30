<?php

namespace App\Providers;

use App\Models\SchoolSetting;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Throwable;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view): void {
            static $schoolSetting = null;

            if (! $schoolSetting) {
                try {
                    $schoolSetting = SchoolSetting::current();
                } catch (Throwable) {
                    $schoolSetting = new SchoolSetting(SchoolSetting::defaults());
                }
            }

            $view->with('schoolSetting', $schoolSetting);
        });
    }
}
