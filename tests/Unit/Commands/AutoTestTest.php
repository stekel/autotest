<?php

use stekel\AutoTest\Commands\AutoTest;
use stekel\AutoTest\Commands\Pest;

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

test('fileListing emits -not -path for each ignored path', function () {
    $autotest = new AutoTest([
        'subCommand' => 'ls',
        'ignoredPaths' => ['vendor', 'node_modules'],
    ]);

    $output = $autotest->get();

    $this->assertStringContainsString('-not -path "./vendor"', $output);
    $this->assertStringContainsString('-not -path "./node_modules"', $output);
});

test('title replaces the pest base command with the {pest} marker', function () {
    $autotest = new AutoTest([
        'subCommand' => Pest::PEST_BASE_COMMAND.' --parallel',
        'ignoredPaths' => null,
    ]);

    $output = $autotest->get();

    $this->assertStringContainsString('{pest} --parallel', $output);
    $this->assertStringNotContainsString('./vendor/bin/pest\033', $output);
});

test('title leaves non-pest subcommands untouched in the running banner', function () {
    $autotest = new AutoTest([
        'subCommand' => './vendor/bin/phpunit --no-coverage',
        'ignoredPaths' => null,
    ]);

    $output = $autotest->get();

    $this->assertStringContainsString('./vendor/bin/phpunit --no-coverage', $output);
    $this->assertStringNotContainsString('{pest}', $output);
});
