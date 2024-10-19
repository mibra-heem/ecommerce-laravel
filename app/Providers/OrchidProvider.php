<?php

namespace App\Providers;

use App\Orchid\Resources\PostResource;
use Illuminate\Support\ServiceProvider;
use Orchid\Crud\Arbitrator;

class OrchidProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(Arbitrator $arbitrator)
    {
        $arbitrator->resources([
            PostResource::class,
        ]);
    }
}
