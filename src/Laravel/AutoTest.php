<?php

namespace stekel\AutoTest\Laravel;

use Illuminate\Console\Command;
use stekel\AutoTest\AutoTest as AutoTestManager;
use stekel\AutoTest\Command as AutoTestCommand;

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
     * Ignored Paths
     *
     * @var array
     */
    protected $ignoredPaths = [
        'vendor/*',
        'storage/*',
        'resources/*',
        'database/*'
    ];
    
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
        
        $command = new AutoTestCommand([
            'filter' => $this->option('filter'),
            'coverage' => $this->option('coverage'),
            'directory' => $this->option('directory'),
            'ignoredPaths' => $this->ignoredPaths
        ]);
        
        (new AutoTestManager($command))->fire();
    }    
}
