<?php

namespace stekel\AutoTest;

use Illuminate\Support\ServiceProvider;
use stekel\AutoTest\Laravel\Console\AutoTest as AutoTestCommand;
use stekel\AutoTest\Laravel\Console\FancyTest as FancyTestCommand;

class AutoTestServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../Config/autotest.php' => config_path('autotest.php'),
        ]);
        
        $this->mergeConfigFrom(
            __DIR__.'/../Config/autotest.php', 'autotest'
        );
    
        if ($this->app->runningInConsole()) {
            
            $this->commands([
                AutoTestCommand::class,
                FancyTestCommand::class,
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
