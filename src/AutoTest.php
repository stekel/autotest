<?php

namespace stekel\AutoTest;

use Exceptions\EntrNotInstalled;
use stekel\AutoTest\Commands\AutoTest as AutoTestCommand;

class AutoTest
{
    /**
     * Package version
     *
     * @var string
     */
    public const AUTOTEST_VERSION = 'v2.0';

    /**
     * Command
     *
     * @var Command
     */
    protected $command;

    /**
     * Construct
     */
    public function __construct(AutoTestCommand $command)
    {
        $this->command = $command;

        $this->checkPreRecs();
    }

    /**
     * Fire up entr to listen for file changes
     *
     * @return void
     */
    public function fire()
    {
        $this->command->fire();
    }

    /**
     * Verify all prerequisites
     *
     * @return void
     */
    private function checkPreRecs()
    {
        if (exec('which entr') == '') {
            throw new EntrNotInstalled('Error: Seems entr is not installed. Try running: sudo apt-get install entr');
        }
    }
}
