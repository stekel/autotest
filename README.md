# AutoTest

Automatically run unit tests when a project file is saved.

## Requirements

- PHP >= 7
- PHPUnit >= 6
- entr >= 3.4

## Laravel Install

- Install entr
```bash
sudo apt-get install entr
```

- Require it with Composer:
```bash
composer require stekel/autotest
```

- (Laravel <= 5.4) Add the service provider at the end of your `config/app.php`:
```php
'providers' => [
    // ...
    stekel\AutoTest\AutoTestServiceProvider::class,
],
```

## Usage

Open a terminal and run the following command

```bash
php artisan stekel:autotest
```

Your tests should run one time, after that autotest will run your tests everytime a file within your project is saved. No more switching between your editor and a terminal.