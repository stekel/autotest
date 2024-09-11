<?php

namespace stekel\AutoTest\Commands;

use Illuminate\Support\Str;

class AutoTest extends Command
{
    /**
     * Handler
     *
     * @return void
     */
    public function handle()
    {
        if ($this->command == '') {
            $this->clear();
            $this->fileListing();
            $this->entr();
        }
    }

    /**
     * Build title
     *
     * @param  bool  $escape
     * @return AutoTest
     */
    public function title($escape = false)
    {
        $subCommand = $this->config['subCommand'];

        if (Str::startsWith($subCommand, Pest::PEST_BASE_COMMAND)) {
            $subCommand = Str::replace(Pest::PEST_BASE_COMMAND, '{pest}', $subCommand);
        }

        $this->command .= 'echo '.(($escape) ? '-e' : '').
            ' \'\033[34mAutoTest '.\stekel\AutoTest\AutoTest::AUTOTEST_VERSION.
            ' Running...\033[0m [\033[36m'.trim($subCommand).
            '\033[0m]\' && ';

        return $this;
    }

    /**
     * Entr
     */
    public function entr()
    {
        $this->command .= 'entr -d bash -c "';
        $this->clear();
        $this->title(true);
        $this->command .= $this->config['subCommand'].' ';
        $this->result();
        $this->command .= '"'." sleep 1 \n done ";

        return $this;
    }

    /**
     * Result
     */
    public function result()
    {
        $this->command .= '&& echo -e \'\033[1m\033[32m\u2713 Tests are passing!\033[0m\' || echo -e \'\r\n\033[1m\033[31mTests are failing!\033[0m\'';

        return $this;
    }

    /**
     * Build file listing command
     *
     * @return Command
     */
    public function fileListing()
    {
        $this->command .= 'while true; do '."\n".'find . -name "*.php" '.implode(' ', collect($this->config['ignoredPaths'])->transform(function ($path) {
            return '-not -path "./'.$path.'"';
        })->toArray()).' | ';

        return $this;
    }
}
