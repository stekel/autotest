<?php

namespace stekel\AutoTest\Tests\Unit\Commands;

use stekel\AutoTest\Commands\AutoTest;
use stekel\AutoTest\Config;
use stekel\AutoTest\Tests\TestCase;

class AutoTestTest extends TestCase
{
    /** @test **/
    public function can_build_base_phpunit_command()
    {
        $autotest = new AutoTest([
            'subCommand' => 'ls',
            'ignoredPaths' => null
        ]);

        $this->assertContains('clear && while true; do '."\n", $autotest->get());
        $this->assertContains('find . -name "*.php" ', $autotest->get());
        $this->assertContains('| entr -d bash -c "clear && echo -e ', $autotest->get());
        $this->assertContains('AutoTest '.(new Config([]))->version.' Running...', $autotest->get());
        $this->assertContains('Tests are passing', $autotest->get());
        $this->assertContains('Tests are failing', $autotest->get());
    }
}