<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Filament\Events\Logout;
use Illuminate\Support\Facades\Event;

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
        Event::listen(Logout::class, function (Logout $event) {
            return redirect('/login'); // <-- força redirecionamento
        });
    }
}
