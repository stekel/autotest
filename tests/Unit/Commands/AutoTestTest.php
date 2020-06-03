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

        $this->assertStringContainsString('clear && while true; do '."\n", $autotest->get());
        $this->assertStringContainsString('find . -name "*.php" ', $autotest->get());
        $this->assertStringContainsString('| entr -d bash -c "clear && echo -e ', $autotest->get());
        $this->assertStringContainsString('AutoTest '.(new Config([]))->version.' Running...', $autotest->get());
        $this->assertStringContainsString('Tests are passing', $autotest->get());
        $this->assertStringContainsString('Tests are failing', $autotest->get());
    }
}
