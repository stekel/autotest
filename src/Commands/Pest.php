<?php

namespace stekel\AutoTest\Commands;

class Pest extends PhpUnit
{
    public const PEST_BASE_COMMAND = 'php -d opcache.enable=0 -d extension=pcov -d pcov.enabled=1 ./vendor/bin/pest';

    /**
     * Handler
     *
     * @return Pest
     */
    public function handle()
    {
        $this->buildPath();

        if (isset($this->config['directory'])) {
            $this->directory();
        }

        if (isset($this->config['filter'])) {
            $this->command .= '--filter '.$this->config['filter'].' ';
        }

        if (isset($this->config['group'])) {
            $this->command .= '--group '.$this->config['group'].' ';
        }

        if (! isset($this->config['coverage']) || ! $this->config['coverage']) {
            $this->command .= '--no-coverage ';
        }

        if (isset($this->config['parallel']) && $this->config['parallel']) {
            $this->command .= '--parallel ';
        }

        $this->command .= '--compact ';

        return $this;
    }

    /**
     * Build the path to phpunit
     *
     * @return void
     */
    private function buildPath()
    {
        $this->command .= self::PEST_BASE_COMMAND.' ';
    }
}
