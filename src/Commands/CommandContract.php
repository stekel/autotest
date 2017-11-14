<?php

namespace stekel\AutoTest\Commands;

/**
 * Command Contract
 */
interface CommandContract {
    
    /**
     * Construct
     */
    public function __construct(array $config=[]);
    
    /**
     * Execute the command and return a handler
     *
     * @return *handler*
     */
    public function execute();
    
    /**
     * Fire the command
     *
     * @return void
     */
    public function fire();
    
    /**
     * Return the command
     *
     * @return string
     */
    public function get();
    
    /**
     * Handler
     *
     * @return void
     */
    public function handle();
}