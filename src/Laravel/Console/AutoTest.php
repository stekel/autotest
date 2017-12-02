<?php

namespace stekel\AutoTest\Laravel\Console;

use Illuminate\Console\Command;
use stekel\AutoTest\AutoTest as AutoTestManager;
use stekel\AutoTest\Commands\AutoTest as AutoTestCommand;
use stekel\AutoTest\Commands\PhpUnit as PhpUnitCommand;
use stekel\AutoTest\Config;

class AutoTest extends Command {
    
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stekel:autotest
                            {--f|filter= : Apply PHPUnit filter}
                            {--c|coverage : Run PHPUnit with code coverage enabled}
                            {--d|directory= : Run PHPUnit on the given test directory (relative to the tests/ directory)}
                            ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Automatically run unit tests when a file is saved by utilizing entr.';
    
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct() {
        
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {
        
        $config = Config::buildFromLaravel();
        
        $subCommand = 'artisan stekel:fancytest';
        
        if ($this->option('filter')) {
            
            $subCommand .= ' -f '.$this->option('filter');
        }
        
        if ($this->option('coverage')) {
            
            $subCommand .= ' -c ';
        }
        
        if ($this->option('directory')) {
            
            $subCommand .= ' -d '.$this->option('directory');
        }
        
        $autoTest = new AutoTestCommand([
            'subCommand' => $subCommand,
            'ignoredPaths' => config('autotest.ignoredPaths')
        ]);
        
        (new AutoTestManager($autoTest, $config))->fire();
    }
}
