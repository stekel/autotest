<?php

namespace stekel\AutoTest;

use stekel\AutoTest\Commands\PhpUnit;

/**
 * FancyTest Class
 */
class FancyTest {
    
    /**
     * Command
     *
     * @var Command
     */
    protected $command;
    
    /**
     * Construct
     */
    public function __construct(PhpUnit $command) {
        
        $this->command = $command;
    }
    
    /**
     * Fire the command and make changes to the output
     *
     * @return void
     */
    public function fire() {
        
        $handle = $this->command->execute();
        $phpunitDone = false;
        
        if (config('autotest.fancyTest.removePhpUnitHeader')) {
            
            $read = fgets($handle);
            
            if (! starts_with($read, 'PHPUnit')) {
                
                rewind($handle);
            }
            
            $read = fgets($handle);
            
            if (! starts_with($read, "\n")) {
                
                rewind($handle);
            }
        }
        
        while (!feof($handle)) {
            
            if ($phpunitDone) {
                
                $read = fgets($handle);
            } else {
                
                $read = fread($handle, 128);
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
            
            if ($output == "ERRORS!\n" || $output == "FAILURES!\n") {
                
                fclose($handle);
                
                return -1;
            }
            
            echo $output;
        }
        
        fclose($handle);
        
        return 0;
    }
}