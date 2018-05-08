<?php

namespace stekel\AutoTest\Commands;

use stekel\AutoTest\Str;

/**
 * PhpUnit Command
 */
class PhpUnit extends Command {
    
    /**
     * Handler
     *
     * @return void
     */
    public function handle() {
        
        $this->buildPath();
        
        if ( isset($this->config['directory']) ) {
            
            $this->directory();
        }
        
        if ( isset($this->config['filter']) ) {
            
            $this->command .= '--filter '.$this->config['filter'].' ';
        }
        
        if ( ! isset($this->config['coverage']) || ! $this->config['coverage'] ) {
            
            $this->command .= '--no-coverage ';
        }
        
        return $this;
    }
    
    /**
     * Build the path to phpunit
     *
     * @return void
     */
    private function buildPath() {
        
        if (isset($this->config['localphpunit']) && $this->config['localphpunit']) {
            
            $this->command .= './vendor/bin/phpunit ';
            return;
        }
            
        $this->command .= $this->basePath.'/vendor/bin/phpunit ';
    }
    
    /**
     * Build directory path
     *
     * @return string
     */
    private function directory() {
        
        $this->command .= $this->basePath.'/tests/'.Str::finish($this->config['directory'], '/').'. ';
        
        return $this;
    }
}