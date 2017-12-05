<?php

namespace stekel\AutoTest;

if (!\function_exists('autoload')) {
    
    function autoload(array $autoloads=null) {
        
        if (is_null($autoloads)) {
            
            $autoloads = [
                __DIR__.'/../vendor/autoload.php',
                __DIR__.'/../../vendor/autoload.php',
                __DIR__.'/../../../../vendor/autoload.php',
            ];
        }
        
        foreach ($autoloads as $autoload) {
            
            if (file_exists($autoload)) {
                
                require $autoload;
                
                break;
            }
        }
    }
}

if (!\function_exists('vendorDirectory')) {
    
    function vendorDirectory() {
        
        if (file_exists(realpath(__DIR__.'/../vendor/bin/phpunit'))) {
            
            return realpath(__DIR__.'/../');
        }
            
        return realpath(__DIR__.'/../../../');
    }
}