<?php

namespace stekel\AutoTest\Tests\Unit;

use stekel\AutoTest\Config;
use stekel\AutoTest\Tests\TestCase;

class ConfigTest extends TestCase {

    /** @test **/
    public function it_can_build_from_the_laravel_config_file() {
        
        $config = Config::buildFromLaravel();
        $ignoredPaths = [
            'vendor/*',
            'storage/*'
        ];
        
        $this->assertEquals($ignoredPaths, $config->ignoredPaths());
        $this->assertTrue($config->simplifyProjectPath());
        $this->assertTrue($config->simplifyLaravelPipeline());
        $this->assertTrue($config->removePhpUnitHeader());
    }
}