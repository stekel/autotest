<?php

namespace stekel\AutoTest;

use stekel\AutoTest\Commands\AutoTest as AutoTestCommand;
use Exceptions\EntrNotInstalled;

/**
 * AutoTest Class
 */
class AutoTest {
    
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
    public function __construct(AutoTestCommand $command, Config $config) {
        
        $this->command = $command;
        $this->config = $config;
        
        $this->checkPreRecs();
    }
    
    /**
     * Fire up entr to listen for file changes
     *
     * @return void
     */
    public function fire() {
        
        $this->command->fire();
    }
    
    /**
     * Verify all prerequisites
     *
     * @return void
     */
    private function checkPreRecs() {
        
        if ( exec('which entr') == '' ) {
            
            throw new EntrNotInstalled('Error: Seems entr is not installed. Try running: sudo apt-get install entr');
        }
    }
}