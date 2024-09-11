<?php

use stekel\AutoTest\Commands\AutoTest;

test('can build base phpunit command', function () {
    $autotest = new AutoTest([
        'subCommand' => 'ls',
        'ignoredPaths' => null,
    ]);

    $this->assertStringContainsString('clear && while true; do '."\n", $autotest->get());
    $this->assertStringContainsString('find . -name "*.php" ', $autotest->get());
    $this->assertStringContainsString('| entr -d bash -c "clear && echo -e ', $autotest->get());
    $this->assertStringContainsString('AutoTest '.\stekel\AutoTest\AutoTest::AUTOTEST_VERSION.' Running...', $autotest->get());
    $this->assertStringContainsString('Tests are passing', $autotest->get());
    $this->assertStringContainsString('Tests are failing', $autotest->get());
});
