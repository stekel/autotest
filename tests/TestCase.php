<?php

namespace stekel\AutoTest\Tests;

use PHPUnit\Framework\TestCase as BaseTestCase;

class TestCase extends BaseTestCase {

    /**
     * Base path
     *
     * @return string
     */
    protected $basePath;

    public function setUp(): void {

        $this->basePath = realpath(__DIR__.'/../');
    }
}
