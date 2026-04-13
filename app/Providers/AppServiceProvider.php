<?php

namespace App\Providers;

use App\Actions\CreateTeamForUser;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Event::listen(Registered::class, function (Registered $event) {
            (new CreateTeamForUser)->execute($event->user);
        });
    }
}
