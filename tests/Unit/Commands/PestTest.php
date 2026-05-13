<?php

use stekel\AutoTest\Commands\Pest;

test('can build base pest command', function () {
    $pest = new Pest;

    $this->assertStringContainsString('php -d opcache.enable=0 ./vendor/bin/pest --no-coverage --parallel --compact ', $pest->get());
});

test('can build a pest command with parameters', function () {
    $pest = new Pest([
        'filter' => 'sample-filter',
        'group' => 'sample-group',
        'directory' => 'sample-directory',
        'coverage' => 'coverage',
    ]);

    $this->assertStringContainsString('php -d opcache.enable=0 ./vendor/bin/pest ./tests/sample-directory/. --filter sample-filter --group sample-group --parallel --compact ', $pest->get());
});
