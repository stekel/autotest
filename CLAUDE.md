# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## What this project is

`stekel/autotest` is a PHP CLI package that watches project files and automatically reruns tests when any `.php` file changes. It wraps `entr` (a file-watching utility) around PHPUnit or Pest.

Two executables are provided:
- `autotest` — watches files via `entr` and reruns tests on every save
- `fancytest` — runs PHPUnit once with filtered/prettified output

## Running tests

```bash
./vendor/bin/pest
```

Run a single test file or filter:
```bash
./vendor/bin/pest --filter "can build base phpunit command"
./vendor/bin/pest tests/Unit/Commands/PhpUnitTest.php
```

## Architecture

The core abstraction is a command-builder pattern:

- `CommandContract` — interface requiring `__construct(array $config)`, `execute()`, `fire()`, `get()`, `handle()`
- `Command` (abstract) — implements `execute()` (via `popen`), `fire()` (via `proc_open`), `get()`, and `clear()`; subclasses build `$this->command` string in `handle()`
- `PhpUnit extends Command` — builds a `./vendor/bin/phpunit` (or global `phpunit`) command string from config keys: `filter`, `group`, `directory`, `coverage`, `globalphpunit`
- `Pest extends PhpUnit` — overrides `buildPath()` to use `./vendor/bin/pest` with pcov; adds `--parallel` and `--compact` support
- `Commands\AutoTest extends Command` — builds the full `entr` watch loop: `while true; do find . -name "*.php" ... | entr -d bash -c "...subCommand..."`
- `AutoTest` (top-level class in `src/AutoTest.php`) — checks that `entr` is installed, then delegates to `Commands\AutoTest::fire()`
- `FancyTest` — runs `PhpUnit::execute()` (returns a stream handle) and filters the output, collapsing Laravel framework stack frames

### How `autotest` entrypoint works

1. Loads vendor autoload via `AutoLoad.php` (searches multiple vendor paths for global/local installs)
2. If `./vendor/bin/pest` exists, builds a `Pest` command; otherwise falls back to `fancytest` (PHPUnit)
3. Passes the built sub-command string to `Commands\AutoTest` as `subCommand`
4. `Commands\AutoTest::handle()` wraps it in the `entr` loop

### Config keys passed to Command constructors

| Key | Used by | Effect |
|-----|---------|--------|
| `filter` | PhpUnit, Pest | `--filter <value>` |
| `group` | PhpUnit, Pest | `--group <value>` |
| `directory` | PhpUnit, Pest | `./tests/<value>/.` |
| `coverage` | PhpUnit, Pest | enables pcov, removes `--no-coverage` |
| `globalphpunit` | PhpUnit | uses global `phpunit` instead of `./vendor/bin/phpunit` |
| `parallel` | Pest | adds `--parallel` |
| `ignoredPaths` | Commands\AutoTest | `-not -path` exclusions for `find` |
| `subCommand` | Commands\AutoTest | the test runner command to pass to `entr` |
| `basePath` | Command | base directory (defaults to two levels above `src/`) |
