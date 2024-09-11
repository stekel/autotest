<?php

namespace stekel\AutoTest\Tests;

use PHPUnit\Framework\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    /**
     * Base path
     *
     * @return string
     */
    public $basePath;

    protected function setUp(): void
    {
        parent::setUp();

        $this->basePath = realpath(__DIR__.'/../');
    }
}
