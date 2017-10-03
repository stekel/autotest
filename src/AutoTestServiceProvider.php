<?php

namespace stekel\AutoTest;

use Illuminate\Support\ServiceProvider;
use stekel\AutoTest\Laravel\AutoTest as AutoTestCommand;

class AutoTestServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            
            $this->commands([
                AutoTestCommand::class,
            ]);
        }
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
