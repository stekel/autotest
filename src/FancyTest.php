<?php

namespace stekel\AutoTest;

use stekel\AutoTest\Commands\PhpUnit;
use stekel\AutoTest\Config;

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
     * Config
     *
     * @return Config
     */
    protected $config;
    
    /**
     * Construct
     */
    public function __construct(PhpUnit $command, Config $config) {
        
        $this->command = $command;
        $this->config = $config;
    }
    
    /**
     * Fire the command and make changes to the output
     *
     * @return void
     */
    public function fire() {
        
        $handle = $this->command->execute();
        $phpunitDone = false;
        
        if ($this->config->removePhpUnitHeader()) {
            
            $read = fgets($handle);
            
            if (! $this->startsWith($read, 'PHPUnit')) {
                
                rewind($handle);
            }
            
            $read = fgets($handle);
            
            if (! $this->startsWith($read, "\n")) {
                
                rewind($handle);
            }
        }
        
        while (!feof($handle)) {
            
            if ($phpunitDone) {
                
                $read = fgets($handle);
            } else {
                
                $read = fread($handle, 128);
            }
            
            if (! $this->stringContains($read, '.')) {
                
                $phpunitDone = true;
            }
            
            $output = $read;
            
            if ($this->config->simplifyLaravelPipeline()) {
                
                if ($this->stringContains($output, 'vendor/laravel')) {
                    
                    echo 'Laravel framework pipline: ';
                    
                    while (true) {
                        
                        $read = fgets($handle);
                        
                        if ($this->stringContains($read, 'vendor/laravel')) {
                            
                            echo '.';
                        } else {
                            
                            echo "\n";
                            $output = $read;
                            break;
                        }
                    }
                }
            }
            
            if ($this->config->simplifyProjectPath() && ! $this->startsWith($output, '-') && ! $this->startsWith($output, '+') ) {
                
                $output = str_replace(__DIR__, '{project}', $output);
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
    
    private function startsWith($string, $query) {
        
        return substr($string, 0, strlen($query)) === $query;
    }
    
    private function stringContains($string, $query) {
        
        return strpos($string, $query) !== false;
    }
}