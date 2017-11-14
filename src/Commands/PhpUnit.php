<?php

namespace stekel\AutoTest\Commands;

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
        
        $this->command .= base_path().'/vendor/bin/phpunit ';
        
        if ( isset($this->config['directory']) ) {
            
            $this->directory();
        }
        
        if (  isset($this->config['filter'])  ) {
            
            $this->command .= '--filter '.$this->config['filter'].' ';
        }
        
        if ( ! isset($this->config['coverage']) && ! $this->config['coverage'] ) {
            
            $this->command .= '--no-coverage ';
        }
        
        return $this;
    }
    
    /**
     * Build directory path
     *
     * @return string
     */
    private function directory() {
        
        $this->command .= base_path().'/tests/'.str_finish($this->config['directory'], '/').'. ';
        
        return $this;
    }
}