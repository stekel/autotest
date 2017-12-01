<?php

namespace stekel\AutoTest\Commands;

/**
 * AutoTest Command
 */
class AutoTest extends Command {
    
    /**
     * AutoTest command
     *
     * @var string
     */
    protected $autoTestCommand;
    
    /**
     * Handler
     *
     * @return void
     */
    public function handle() {
        
        $this->clear();
        $this->fileListing();
        $this->entr();
    }
    
    /**
     * Build title
     *
     * @param  boolean $escape
     */
    public function title($escape=false) {
        
        $this->command .= 'echo '.(($escape) ? '-e' : '').
            ' \'\033[34mAutoTest Running...\033[0m [\033[36m'.$this->config['subCommand'].
            '\033[0m]\r\n\' && ';
        
        return $this;
    }
    
    /**
     * Entr
     */
    public function entr() {
        
        $this->command .= 'entr bash -c "';
        $this->clear();
        $this->title(true);
        $this->command .= $this->config['subCommand'].' ';
        $this->result();
        $this->command .= '"';
        
        return $this;
    }
    
    /**
     * Result
     */
    public function result() {
        
        $this->command .= '&& echo -e \'\r\n\033[1m\033[32m\u2713 Tests are passing!\033[0m\' || echo -e \'\r\n\033[1m\033[31mTests are failing!\033[0m\'';
        
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
}