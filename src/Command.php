<?php

namespace stekel\AutoTest;

/**
 * Command Class
 */
class Command {
    
    /**
     * Command to run
     * 
     * @var string
     */
    protected $command = '';
    
    /**
     * Configuration
     * 
     * @var array
     */
    protected $config = [];
    
    /**
     * Construct
     */
    public function __construct(array $config=[]) {
        
        $this->config = $config;
    }
    
    /**
     * Execute the command
     * 
     * @return void
     */
    public function execute() {
        
        passthru($this->command);
    }
    
    /**
     * Return the command
     * 
     * @return string
     */
    public function get() {
        
        return $this->command;
    }
    
    /**
     * Clear
     * 
     * @return Command
     */
    public function clear() {
        
        $this->command .= 'clear && ';
        
        return $this;
    }
    
    /**
     * Build title
     * 
     * @param  boolean $escape
     * @return Command
     */
    public function title($escape=false) {
        
        $this->command .= 'echo '.(($escape) ? '-e' : '').
            ' \'Auto-Testing is Running... [phpunit '.
            ( ( isset($this->config['directory']) ) ? '--directory '.$this->config['directory'] : '').
            ( ( isset($this->config['filter']) ) ? '--filter '.$this->config['filter'] : '').
            ( ( isset($this->config['coverage']) && $this->config['coverage'] ) ? '' : ' --no-coverage').
            ']\r\n\' && ';
            
        return $this;
    }
    
    /**
     * Entr
     * 
     * @return Command
     */
    public function entr() {
        
        $this->command .= 'entr bash -c "';
        $this->phpunit();
        $this->command .= '"';
        
        return $this;
    }
    
    /**
     * PhpUnit
     * 
     * @return Command
     */
    public function phpunit() {
        
        $this->clear();
        $this->title(true);
        
        $this->command .= getcwd().'/vendor/bin/phpunit ';
        
        if ( isset($this->config['directory']) ) {
            
            $this->directory();
        }
        
        if (  isset($this->config['filter'])  ) {
            
            $this->command .= '--filter '.$this->config['filter'].' ';
        }
        
        if ( ! isset($this->config['coverage']) && ! $this->config['coverage'] ) {
            
            $this->command .= '--no-coverage ';
        }
        
        $this->command .= '&& echo -e \'\r\nTests are Passing!\' || echo -e \'\r\nOops...something failed!\'';
        
        return $this;
    }
    
    /**
     * Build file listing command
     * 
     * @return Command
     */
    public function fileListing() {
        
        $this->command .= 'find . -name "*.php" '.implode(' ', collect($this->config['ignoredPaths'])->transform(function($path) {
            
            return '-not -path "./'.$path.'"';
        })->toArray()).' | ';
        
        return $this;
    }
    
    /**
     * Build directory path
     * 
     * @return string
     */
    public function directory() {
        
        $this->command .= base_path().'/tests/'.$this->config['directory'].'/. ';
        
        return $this;
    }
}