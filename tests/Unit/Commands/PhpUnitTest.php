<?php

use stekel\AutoTest\Commands\PhpUnit;

test('can build base phpunit command', function () {
    $phpunit = new PhpUnit();

    expect($phpunit->get())->toEqual('./vendor/bin/phpunit --no-coverage ');
});

test('can build base phpunit command with local path', function () {
    $phpunit = new PhpUnit([
        'localphpunit' => true,
    ]);

    expect($phpunit->get())->toEqual('./vendor/bin/phpunit --no-coverage ');
});

test('can build base phpunit command with global path', function () {
    $phpunit = new PhpUnit([
        'globalphpunit' => true,
    ]);

    expect($phpunit->get())->toEqual('phpunit --no-coverage ');
});

test('can build phpunit command with directory', function () {
    $phpunit = new PhpUnit([
        'directory' => 'Unit/',
    ]);

    expect($phpunit->get())->toEqual('./vendor/bin/phpunit ./tests/Unit/. --no-coverage ');
});

test('can build phpunit command with a filter', function () {
    $phpunit = new PhpUnit([
        'filter' => 'UserTest',
    ]);

    expect($phpunit->get())->toEqual('./vendor/bin/phpunit --filter UserTest --no-coverage ');
});

test('can build phpunit command with a group', function () {
    $phpunit = new PhpUnit([
        'group' => 'Authentication',
    ]);

    expect($phpunit->get())->toEqual('./vendor/bin/phpunit --group Authentication --no-coverage ');
});

test('can build phpunit command with code coverage', function () {
    $phpunit = new PhpUnit([
        'coverage' => true,
    ]);

    $path = str_replace('tests/Unit', 'src', __DIR__);

    expect($phpunit->get())->toEqual('php -d extension=pcov -d pcov.enabled=1 ./vendor/bin/phpunit ');
});

test('can build phpunit command with code coverage and directory', function () {
    $phpunit = new PhpUnit([
        'coverage' => true,
        'directory' => 'Unit/',
    ]);

    $path = str_replace('tests/Unit', 'src', __DIR__);

    expect($phpunit->get())->toEqual('php -d extension=pcov -d pcov.enabled=1 ./vendor/bin/phpunit ./tests/Unit/. ');
});
