<?php

require_once __DIR__.'/../../src/AutoLoad.php';

use function stekel\AutoTest\autoload;
use function stekel\AutoTest\vendorDirectory;

test('autoload requires the first existing path and stops', function () {
    $sentinel = tempnam(sys_get_temp_dir(), 'autotest-loaded-').'.php';
    $marker = sys_get_temp_dir().'/autotest-marker-'.uniqid().'.txt';
    file_put_contents($sentinel, "<?php file_put_contents('".$marker."', 'loaded');\n");

    $unreached = tempnam(sys_get_temp_dir(), 'autotest-unreached-').'.php';
    $unreachedMarker = sys_get_temp_dir().'/autotest-marker-'.uniqid().'.txt';
    file_put_contents($unreached, "<?php file_put_contents('".$unreachedMarker."', 'loaded');\n");

    autoload([$sentinel, $unreached]);

    $this->assertSame('loaded', @file_get_contents($marker));
    $this->assertFalse(file_exists($unreachedMarker));

    @unlink($sentinel);
    @unlink($unreached);
    @unlink($marker);
});

test('autoload silently falls through when no path exists', function () {
    autoload(['/nonexistent/path/'.uniqid().'.php']);

    $this->assertTrue(true);
});

test('vendorDirectory returns project root when local vendor/bin/phpunit exists', function () {
    $expected = realpath(__DIR__.'/../../');

    $this->assertSame($expected, vendorDirectory());
});
