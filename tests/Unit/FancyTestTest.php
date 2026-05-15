<?php

use stekel\AutoTest\Commands\PhpUnit;
use stekel\AutoTest\FancyTest;

class StubbedPhpUnit extends PhpUnit
{
    public string $output = '';

    public function execute()
    {
        $handle = fopen('php://memory', 'r+');
        fwrite($handle, $this->output);
        rewind($handle);

        return $handle;
    }
}

function runFancyTest(string $output): string
{
    $command = new StubbedPhpUnit;
    $command->output = $output;

    $fancy = new FancyTest($command);

    ob_start();
    $fancy->fire();

    return ob_get_clean();
}

// The fire() loop:
// - First fgets must start with "PHPUnit" (else rewinds and re-reads)
// - Second fgets must start with "\n" (else rewinds)
// - Subsequent reads alternate: fread(128) until $phpunitDone, then fgets()
// - $phpunitDone flips to true on the first chunk that does NOT contain '.'
// - Lines that exactly equal "ERRORS!\n" or "FAILURES!\n" trigger early return

test('passes PHPUnit output through with header lines stripped', function () {
    $output = "PHPUnit 10.5.0\n\nrunning tests\n";

    $result = runFancyTest($output);

    $this->assertStringContainsString('running tests', $result);
    $this->assertStringNotContainsString('PHPUnit 10.5.0', $result);
});

test('rewinds when the stream does not start with PHPUnit header', function () {
    $output = "Some other tool\noutput\n";

    $result = runFancyTest($output);

    $this->assertStringContainsString('Some other tool', $result);
});

test('skips Runtime and Configuration lines', function () {
    // Runtime block is consumed by the inner while loop and discarded.
    $output = "PHPUnit 10.5.0\n\nRuntime:       PHP 8.4\nConfiguration: phpunit.xml\nafter-config\n";

    $result = runFancyTest($output);

    $this->assertStringContainsString('after-config', $result);
});

test('returns early when a FAILURES! line appears after phpunit completes', function () {
    // 200 bytes of "A" (no dots, no newlines) forces phpunitDone=true on the
    // first fread(128), leaving the remaining bytes for fgets to pick up.
    $output = "PHPUnit 10.5.0\n\n".str_repeat('A', 200)."\nFAILURES!\nshould-not-appear\n";

    $result = runFancyTest($output);

    $this->assertStringNotContainsString('should-not-appear', $result);
});

test('returns early when an ERRORS! line appears after phpunit completes', function () {
    $output = "PHPUnit 10.5.0\n\n".str_repeat('B', 200)."\nERRORS!\nshould-not-appear\n";

    $result = runFancyTest($output);

    $this->assertStringNotContainsString('should-not-appear', $result);
});

test('collapses laravel framework stack frames into a single pipeline line', function () {
    // Force phpunitDone=true, then deliver a chunk containing 'vendor/laravel'
    // followed by more laravel lines and a final non-laravel line.
    $output = "PHPUnit 10.5.0\n\n"
        .str_repeat('C', 100)."vendor/laravel/framework/src/Foo.php\n"
        ."vendor/laravel/framework/src/Bar.php\n"
        ."vendor/laravel/framework/src/Baz.php\n"
        ."app/Models/User.php\n";

    $result = runFancyTest($output);

    $this->assertStringContainsString('Laravel framework pipline:', $result);
    $this->assertStringContainsString('app/Models/User.php', $result);
});
