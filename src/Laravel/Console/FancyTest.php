<?php

namespace stekel\AutoTest\Laravel\Console;

use Illuminate\Console\Command;
use stekel\AutoTest\Commands\PhpUnit;
use stekel\AutoTest\Config;
use stekel\AutoTest\FancyTest as FancyTestManager;

class FancyTest extends Command {

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stekel:fancytest
                            {--f|filter= : Apply PHPUnit filter}
                            {--g|group= : Apply PHPUnit group}
                            {--c|coverage : Run PHPUnit with code coverage enabled}
                            {--d|directory= : Run PHPUnit on the given test directory (relative to the tests/ directory)}
                            ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fancy wrapper for phpunit tests.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct() {

        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {

        $config = Config::buildFromLaravel();

        $command = new PhpUnit([
            'filter' => $this->option('filter'),
            'group' => $this->option('group'),
            'coverage' => $this->option('coverage'),
            'directory' => $this->option('directory'),
            'ignoredPaths' => config('autotest.ignoredPaths'),
            'basePath' => base_path()
        ]);

        return (new FancyTestManager($command, $config))->fire();
    }
}
