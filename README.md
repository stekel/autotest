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

- Add the service provider at the end of your `config/app.php`:
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