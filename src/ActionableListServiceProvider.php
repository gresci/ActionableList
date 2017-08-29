<?php

namespace GaspariLab\ActionableList;

use Illuminate\Support\ServiceProvider;

class ActionableListServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/views', 'actionablelist');

        $this->publishes([
            __DIR__.'/views' => resource_path('views/vendor/actionablelist'),
        ]);
    }
}
