<?php

namespace stekel\AutoTest\Tests\Unit\Commands;

use stekel\AutoTest\Config;
use stekel\AutoTest\Commands\AutoTest;
use stekel\AutoTest\Tests\TestCase;

class AutoTestTest extends TestCase {

    /** @test **/
    public function can_build_base_phpunit_command() {
        
        $autotest = new AutoTest([
            'subCommand' => 'ls',
            'ignoredPaths' => null
        ]);
        
        $this->assertContains('clear && ', $autotest->get());
        $this->assertContains('find . -name "*.php" ', $autotest->get());
        $this->assertContains('| entr bash -c "clear && echo -e ', $autotest->get());
        $this->assertContains('AutoTest Running...', $autotest->get());
        $this->assertContains('Tests are passing', $autotest->get());
        $this->assertContains('Tests are failing', $autotest->get());
    }
}