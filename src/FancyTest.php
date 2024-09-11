<?php

namespace stekel\AutoTest;

use Illuminate\Support\Str;
use stekel\AutoTest\Commands\PhpUnit;

class FancyTest
{
    /**
     * Command
     *
     * @var Command
     */
    protected $command;

    /**
     * Construct
     */
    public function __construct(PhpUnit $command)
    {
        $this->command = $command;
    }

    /**
     * Fire the command and make changes to the output
     *
     * @return void
     */
    public function fire()
    {
        $handle = $this->command->execute();
        $phpunitDone = false;

        $read = fgets($handle);

        if ($read) {
            if (! Str::startsWith($read, 'PHPUnit')) {
                rewind($handle);
            }

            $read = fgets($handle);

            if ($read) {
                if (! Str::startsWith($read, "\n")) {
                    rewind($handle);
                }
            }
        }

        while (! feof($handle)) {
            if ($phpunitDone) {
                $read = fgets($handle);
            } else {
                $read = fread($handle, 128);
            }

            while (! feof($handle) && (Str::startsWith($read, 'Runtime') || Str::startsWith($read, 'Configuration'))) {
                $read = fread($handle, 128);
            }

            if (! Str::contains($read, '.')) {
                $phpunitDone = true;
            }

            $output = $read;

            if (Str::contains($output, 'vendor/laravel')) {
                echo 'Laravel framework pipline: ';

                while (true) {
                    $read = fgets($handle);

                    if (Str::contains($read, 'vendor/laravel')) {
                        echo '.';
                    } else {
                        echo "\n";
                        $output = $read;
                        break;
                    }
                }
            }

            if (! Str::startsWith($output, '-') && ! Str::startsWith($output, '+')) {
                $output = str_replace(__DIR__, '{project}', $output);
            }

            if ($output == "ERRORS!\n" || $output == "FAILURES!\n") {
                fclose($handle);

                return -1;
            }

            echo $output;
        }

        fclose($handle);

        return 0;
    }
}
