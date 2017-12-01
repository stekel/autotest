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
