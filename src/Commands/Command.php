<?php

namespace stekel\AutoTest\Commands;

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
     *
     * @param array $config
     */
    public function __construct(array $config=[]) {
        
        $this->basePath = isset($config['basePath']) ? $config['basePath'] : realpath(__DIR__.'/../../');
        
        $this->config = $config;
    }

    /**
     * Execute the command and return a handler
     *
     * @return bool|resource *handler
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
}