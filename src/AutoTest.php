<?php

namespace stekel\AutoTest;

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
     * Construct
     */
    public function __construct(Command $command) {
        
        $this->command = $command;
        
        $this->checkPreRecs();
    }
    
    /**
     * Fire up entr to listen for file changes
     * 
     * @return void
     */
    public function fire() {
        
        $this->command
            ->clear()
            ->title()
            ->fileListing()
            ->entr();
        // dd($this->command->get());
        $this->command->execute();
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