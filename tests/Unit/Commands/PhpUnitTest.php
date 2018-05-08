<?php

namespace stekel\AutoTest\Tests\Unit\Commands;

use stekel\AutoTest\Commands\PhpUnit;
use stekel\AutoTest\Tests\TestCase;

class PhpUnitTest extends TestCase {

    /** @test **/
    public function can_build_base_phpunit_command() {
        
        $phpunit = new PhpUnit();
        
        $this->assertEquals($this->basePath.'/vendor/bin/phpunit --no-coverage ', $phpunit->get());
    }
    
    /** @test **/
    public function can_build_base_phpunit_command_with_local_path() {
        
        $phpunit = new PhpUnit([
            'localphpunit' => true,
        ]);
        
        $this->assertEquals('./vendor/bin/phpunit --no-coverage ', $phpunit->get());
    }
    
    /** @test **/
    public function can_build_phpunit_command_with_directory() {
        
        $phpunit = new PhpUnit([
            'directory' => 'Unit/'
        ]);
        
        $this->assertEquals($this->basePath.'/vendor/bin/phpunit '.$this->basePath.'/tests/Unit/. --no-coverage ', $phpunit->get());
    }
    
    /** @test **/
    public function can_build_phpunit_command_with_a_filter() {
        
        $phpunit = new PhpUnit([
            'filter' => 'UserTest'
        ]);
        
        $this->assertEquals($this->basePath.'/vendor/bin/phpunit --filter UserTest --no-coverage ', $phpunit->get());
    }
    
    /** @test **/
    public function can_build_phpunit_command_with_code_coverage() {
        
        $phpunit = new PhpUnit([
            'coverage' => true
        ]);
        
        $this->assertEquals($this->basePath.'/vendor/bin/phpunit ', $phpunit->get());
    }
    
    /** @test **/
    public function can_build_phpunit_command_with_code_coverage_and_directory() {
        
        $phpunit = new PhpUnit([
            'coverage' => true,
            'directory' => 'Unit/'
        ]);
        
        $this->assertEquals($this->basePath.'/vendor/bin/phpunit '.$this->basePath.'/tests/Unit/. ', $phpunit->get());
    }
}