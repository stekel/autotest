<?php

use stekel\AutoTest\Commands\Command;

class CommandTestStub extends Command
{
    public string $builtCommand = 'echo hi';

    public function handle()
    {
        if ($this->command === '') {
            $this->command = $this->builtCommand;
        }
    }

    public function readBasePath(): ?string
    {
        return $this->basePath;
    }
}

test('basePath defaults to project root when not provided', function () {
    $cmd = new CommandTestStub;

    $this->assertSame(realpath(__DIR__.'/../../../'), $cmd->readBasePath());
});

test('basePath honors config override', function () {
    $cmd = new CommandTestStub(['basePath' => '/tmp/somewhere']);

    $this->assertSame('/tmp/somewhere', $cmd->readBasePath());
});

test('clear prepends "clear &&" and returns the command for chaining', function () {
    $cmd = new CommandTestStub;

    $returned = $cmd->clear();

    $this->assertSame($cmd, $returned);
    $this->assertStringStartsWith('clear && ', $cmd->get());
});

test('get returns the assembled command string from handle', function () {
    $cmd = new CommandTestStub;
    $cmd->builtCommand = 'echo built-by-handle';

    $this->assertSame('echo built-by-handle', $cmd->get());
});
