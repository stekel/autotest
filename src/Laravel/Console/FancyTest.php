<?php

namespace stekel\AutoTest\Laravel\Console;

use Illuminate\Console\Command;
use stekel\AutoTest\Commands\PhpUnit;

class FancyTest extends Command {
    
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stekel:fancytest
                            {--f|filter= : Apply PHPUnit filter}
                            {--c|coverage : Run PHPUnit with code coverage enabled}
                            {--d|directory= : Run PHPUnit on the given test directory (relative to the tests/ directory)}
                            ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fancy wrapper for phpunit tests.';
    
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
        
        $command = new PhpUnit([
            'filter' => $this->option('filter'),
            'coverage' => $this->option('coverage'),
            'directory' => $this->option('directory'),
            'ignoredPaths' => config('autotest.ignoredPaths')
        ]);
        
        $handle = $command->execute();
        $phpunitDone = false;
        
        while (true) {
            
            if ($phpunitDone) {
                
                $read = fgets($handle);
            } else {
                
                $read = fread($handle, 256);
            }
            
            if (! str_contains($read, '.')) {
                
                $phpunitDone = true;
            }
            
            $output = $read;
            
            if (config('autotest.fancyTest.simplifyLaravelPipeline')) {
                
                if (str_contains($output, 'vendor/laravel')) {
                    
                    echo 'Laravel framework pipline: ';
                    
                    while (true) {
                        
                        $read = fgets($handle);
                        
                        if (str_contains($read, 'vendor/laravel')) {
                            
                            echo '.';
                        } else {
                            
                            echo "\n";
                            $output = $read;
                            break;
                        }
                    }
                }
            }
            
            if (config('autotest.fancyTest.simplifyProjectPath')) {
                
                $output = str_replace(base_path(), '{project}', $output);
            }
            
            echo $output;
            
            if ($output == "") {
                
                break;
            }
        }
    }
}
