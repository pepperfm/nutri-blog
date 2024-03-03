<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Http\Responders\JsonResponder;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->instance(JsonResponder::class, JsonResponder::class);
    }
}
