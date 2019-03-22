<?php

namespace stekel\AutoTest;

class Config {
    
    /**
     * Params
     *
     * @var array
     */
    protected $params;

    /**
     * Package version
     *
     * @var string
     */
    public $version = 'v0.7';
    
    /**
     * Construct
     *
     * @param array $params
     */
    public function __construct(array $params) {
        
        $this->params = $params;
    }
    
    public static function buildFromLaravel() {
    
        $params = require __DIR__.'/Laravel/Config/autotest.php';
        
        return new Config($params);
    }
    
    public function ignoredPaths() {
    
        return (isset($this->params['ignoredPaths'])) ? $this->params['ignoredPaths'] : null;
    }
    
    public function simplifyProjectPath() {
    
        return (isset($this->params['fancyTest']['simplifyProjectPath'])) ? $this->params['fancyTest']['simplifyProjectPath'] : null;
    }
    
    public function simplifyLaravelPipeline() {
    
        return (isset($this->params['fancyTest']['simplifyLaravelPipeline'])) ? $this->params['fancyTest']['simplifyLaravelPipeline'] : null;
    }
    
    public function removePhpUnitHeader() {
    
        return (isset($this->params['fancyTest']['removePhpUnitHeader'])) ? $this->params['fancyTest']['removePhpUnitHeader'] : null;
    }
}