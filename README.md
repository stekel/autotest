# AutoTest

Automatically run unit tests when a project file is saved.

## Requirements

- PHP >= 7
- PHPUnit >= 6
- entr >= 3.4

## Installation

### Laravel

- Install entr
```bash
sudo apt-get install entr
```

- Require it with Composer:
```bash
composer require stekel/autotest --dev
```

- (Laravel <= 5.4) Add the service provider at the end of your `config/app.php`:
```php
'providers' => [
    
    // ...
    
    stekel\AutoTest\AutoTestServiceProvider::class,
],
```

### Generic

- Install entr
```bash
sudo apt-get install entr
```

- Require it with Composer:
```bash
composer global require stekel/autotest
```

 The `autotest` executable should now be located in the `~/.composer/vendor/bin/` directory.

- Add this directory to your PATH in your ~/.bash_profile or ~/.bashrc
```bash
export PATH=~/.composer/vendor/bin:$PATH
```

## Usage

### Laravel

Run the following command from the root of a Laravel application

```bash
php artisan stekel:autotest
```
Note: this will use the local phpunit `./vendor/bin/phpunit`

### Generic

Run the following command from the root of a composer project with phpunit

```bash
autotest
```
Note: this will use the global phpunit `~/.composer/vendor/bin/phpunit`

Your tests should run one time, after that `autotest` will run your tests every time a file within your project is saved. No more switching between your editor and a terminal.

## Arguments & Flags

`-f` Filter: passed to phpunit as the --filter parameter

`-g` Group: passed to phpunit as the --group parameter

`-d` Directory: passed to phpunit as the directory argument, prepends './tests/'

`--coverage` Code Coverage: pending phpunit is configured to output code coverage reports, removes the `--no-coverage` flag

`--localphpunit` Force Local phpunit: forces the use of `./vendor/bin/phpunit` as the phpunit location

`--globalphpunit` Force Global phpunit: forces the use of `~/.composer/vendor/bin/phpunit` as the phpunit location
