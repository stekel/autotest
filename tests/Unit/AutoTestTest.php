<?php

use stekel\AutoTest\AutoTest;
use stekel\AutoTest\Commands\AutoTest as AutoTestCommand;

class RecordingAutoTestCommand extends AutoTestCommand
{
    public int $fireCalls = 0;

    public function fire()
    {
        $this->fireCalls++;
    }
}

test('constructor stores command and passes pre-req check when entr is installed', function () {
    if (exec('which entr') === '') {
        $this->markTestSkipped('entr is not installed on this host');
    }

    $command = new AutoTestCommand([
        'subCommand' => 'ls',
        'ignoredPaths' => null,
    ]);

    $autotest = new AutoTest($command);

    $ref = new ReflectionClass($autotest);
    $prop = $ref->getProperty('command');
    $prop->setAccessible(true);

    $this->assertSame($command, $prop->getValue($autotest));
});

test('constructor throws when entr cannot be found on PATH', function () {
    $originalPath = getenv('PATH');
    $emptyDir = sys_get_temp_dir().'/autotest-empty-path-'.uniqid();
    mkdir($emptyDir);
    putenv('PATH='.$emptyDir);

    try {
        $command = new AutoTestCommand([
            'subCommand' => 'ls',
            'ignoredPaths' => null,
        ]);

        $threw = false;
        try {
            new AutoTest($command);
        } catch (\Throwable $e) {
            $threw = true;
        }

        $this->assertTrue($threw, 'Expected an exception when entr is missing from PATH');
    } finally {
        putenv('PATH='.$originalPath);
        @rmdir($emptyDir);
    }
});

test('fire delegates to the inner command', function () {
    if (exec('which entr') === '') {
        $this->markTestSkipped('entr is not installed on this host');
    }

    $command = new RecordingAutoTestCommand([
        'subCommand' => 'ls',
        'ignoredPaths' => null,
    ]);

    $autotest = new AutoTest($command);
    $autotest->fire();

    $this->assertSame(1, $command->fireCalls);
});
