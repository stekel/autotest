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
        
        $this->command .= $this->basePath.'/vendor/bin/phpunit ';
        
        if ( isset($this->config['directory']) ) {
            
            $this->directory();
        }
        
        if (  isset($this->config['filter'])  ) {
            
            $this->command .= '--filter '.$this->config['filter'].' ';
        }
        
        if ( ! isset($this->config['coverage']) || ! $this->config['coverage'] ) {
            
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
        
        $this->command .= $this->basePath.'/tests/'.$this->stringFinish($this->config['directory'], '/').'. ';
        
        return $this;
    }
}