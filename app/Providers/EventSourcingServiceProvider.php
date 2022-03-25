<?php

namespace App\Providers;

use App\Projectors\TodoProjector;
use App\Projectors\UserProjector;
use Illuminate\Support\ServiceProvider;
use Spatie\EventSourcing\Facades\Projectionist;

class EventSourcingServiceProvider extends ServiceProvider
{

    public function register()
    {
        // you can also add multiple projectors in one go
        Projectionist::addProjectors(
            [
                TodoProjector::class,
                UserProjector::class,
            ]
        );
    }
}
