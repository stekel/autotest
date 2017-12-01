<?php

namespace stekel\AutoTest\Commands;

/**
 * Command Class
 */
abstract class Command implements CommandContract {
    
    /**
     * Command
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
     * Base path
     *
     * @return string
     */
    protected $basePath;
    
    /**
     * Construct
     */
    public function __construct(array $config=[]) {
        
        $this->basePath = realpath(__DIR__.'/../../');
        
        $this->config = $config;
    }
    
    /**
     * Execute the command and return a handler
     *
     * @return *handler*
     */
    public function execute() {
        
        $this->handle();
        
        return popen($this->command, "r");
    }
    
    /**
     * Fire the command
     *
     * @return void
     */
    public function fire() {
        
        $this->handle();
        
        passthru($this->command);
    }
    
    /**
     * Return the command
     *
     * @return string
     */
    public function get() {
        
        $this->handle();
        
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
    
    public function stringFinish($value, $cap) {
    
        $quoted = preg_quote($cap, '/');
        
        return preg_replace('/(?:'.$quoted.')+$/u', '', $value).$cap;
    }
}