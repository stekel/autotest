<?php

namespace stekel\AutoTest\Commands;

use stekel\AutoTest\Str;

class PhpUnit extends Command {

    /**
     * Handler
     *
     * @return PhpUnit
     */
    public function handle() {

        $this->buildPath();

        if ( isset($this->config['directory']) ) {

            $this->directory();
        }

        if ( isset($this->config['filter']) ) {

            $this->command .= '--filter '.$this->config['filter'].' ';
        }

        if ( isset($this->config['group']) ) {

            $this->command .= '--group '.$this->config['group'].' ';
        }

        if ( ! isset($this->config['coverage']) || ! $this->config['coverage'] ) {

            $this->command .= '--no-coverage ';
        }

        return $this;
    }

    /**
     * Build the path to phpunit
     *
     * @return void
     */
    private function buildPath() {

        if (isset($this->config['coverage']) && $this->config['coverage']) {
            $this->command .= 'php -c '.__DIR__.'/../enable_xdebug.ini ';
            $this->command .= '-d extension=pcov -d pcov.enabled=1 ';
        }

        if (isset($this->config['localphpunit']) && $this->config['localphpunit']) {

            $this->command .= './vendor/bin/phpunit ';
            return;
        }

        if (isset($this->config['globalphpunit']) && $this->config['globalphpunit']) {

            $this->command .= 'phpunit ';
            return;
        }

        $this->command .= './vendor/bin/phpunit ';
    }

    /**
     * Build directory path
     *
     * @return string
     */
    private function directory() {

        $this->command .= './tests/'.Str::finish($this->config['directory'], '/').'. ';

        return $this;
    }
}
