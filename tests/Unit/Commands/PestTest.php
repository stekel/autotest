<?php

use stekel\AutoTest\Commands\Pest;

test('can build base pest command', function () {
    $pest = new Pest();

    $this->assertStringContainsString('php -d opcache.enable=0 -d extension=pcov -d pcov.enabled=1 ./vendor/bin/pest --no-coverage --compact ', $pest->get());
});

test('can build a pest command with parameters', function () {
    $pest = new Pest([
        'filter' => 'sample-filter',
        'group' => 'sample-group',
        'directory' => 'sample-directory',
        'coverage' => 'coverage',
        'parallel' => 'parallel',
    ]);

    $this->assertStringContainsString('php -d opcache.enable=0 -d extension=pcov -d pcov.enabled=1 ./vendor/bin/pest ./tests/sample-directory/. --filter sample-filter --group sample-group --parallel --compact ', $pest->get());
});
