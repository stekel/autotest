<?php

namespace stekel\AutoTest\Tests\Unit\Commands;

use stekel\AutoTest\Commands\PhpUnit;
use stekel\AutoTest\Tests\TestCase;

class PhpUnitTest extends TestCase {

    /** @test **/
    public function can_build_base_phpunit_command() {
        
        $phpunit = new PhpUnit();
        
        $this->assertEquals('./vendor/bin/phpunit --no-coverage ', $phpunit->get());
    }
    
    /** @test **/
    public function can_build_base_phpunit_command_with_local_path() {
        
        $phpunit = new PhpUnit([
            'localphpunit' => true,
        ]);
        
        $this->assertEquals('./vendor/bin/phpunit --no-coverage ', $phpunit->get());
    }
    
    /** @test **/
    public function can_build_base_phpunit_command_with_global_path() {
        
        $phpunit = new PhpUnit([
            'globalphpunit' => true,
        ]);
        
        $this->assertEquals('phpunit --no-coverage ', $phpunit->get());
    }
    
    /** @test **/
    public function can_build_phpunit_command_with_directory() {
        
        $phpunit = new PhpUnit([
            'directory' => 'Unit/'
        ]);
        
        $this->assertEquals('./vendor/bin/phpunit ./tests/Unit/. --no-coverage ', $phpunit->get());
    }
    
    /** @test **/
    public function can_build_phpunit_command_with_a_filter() {
        
        $phpunit = new PhpUnit([
            'filter' => 'UserTest'
        ]);
        
        $this->assertEquals('./vendor/bin/phpunit --filter UserTest --no-coverage ', $phpunit->get());
    }
    
    /** @test **/
    public function can_build_phpunit_command_with_code_coverage() {
        
        $phpunit = new PhpUnit([
            'coverage' => true
        ]);

        $path = str_replace('tests/Unit', 'src', __DIR__);

        $this->assertEquals('php -c '.$path.'/../enable_xdebug.ini ./vendor/bin/phpunit ', $phpunit->get());
    }
    
    /** @test **/
    public function can_build_phpunit_command_with_code_coverage_and_directory() {
        
        $phpunit = new PhpUnit([
            'coverage' => true,
            'directory' => 'Unit/'
        ]);

        $path = str_replace('tests/Unit', 'src', __DIR__);

        $this->assertEquals('php -c '.$path.'/../enable_xdebug.ini ./vendor/bin/phpunit ./tests/Unit/. ', $phpunit->get());
    }
}