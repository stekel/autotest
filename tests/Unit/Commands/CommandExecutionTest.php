<?php

use stekel\AutoTest\Commands\Command;

class ExecutableCommandStub extends Command
{
    public string $builtCommand = '';

    public function handle()
    {
        if ($this->command === '') {
            $this->command = $this->builtCommand;
        }
    }
}

test('execute returns a stream containing the command output', function () {
    $cmd = new ExecutableCommandStub;
    $cmd->builtCommand = 'echo hello-autotest';

    $handle = $cmd->execute();

    $this->assertIsResource($handle);

    $output = '';
    while (! feof($handle)) {
        $output .= fread($handle, 1024);
    }
    pclose($handle);

    $this->assertStringContainsString('hello-autotest', $output);
});

test('fire runs the command to completion with a side-effect', function () {
    $marker = sys_get_temp_dir().'/autotest-fire-'.uniqid().'.txt';
    $cmd = new ExecutableCommandStub;
    $cmd->builtCommand = "touch {$marker}";

    $cmd->fire();

    $this->assertFileExists($marker);

    @unlink($marker);
});
