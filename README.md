# RabbitLoggerPackage

## Introduction


## License

RabbitLogger is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)

## Official Documentation

To get started use Composer to add the package to your project's dependencies:

    composer require kasan/logger-package

### Configuration

After installing the library, register the `kashirin\rabbit_mq\RabbitLoggerServiceProvider` in your `config/app.php` configuration file:

```php
'providers' => [
    // Other service providers...

    kashirin\rabbit_mq\RabbitLoggerServiceProvider::class,
],
```

Also, add the `RabbitLogger` facade to the `aliases` array in your `app` configuration file:

```php
'RabbitLogger' => kashirin\rabbit_mq\Facades\RabbitLogger::class,
```

You will also need to add credentials in your `config/services.php` configuration file. For example:

```php
'rabbit_logger' => [
    'host' => 'your-rabbit-host',
    'port' => 'your-rabbit-port',
    'user' => 'your-rabbit-user-name',
    'password' => 'your-rabbit-user-password',
    'exchange' => 'your-rabbit-exchange'
    'facility' => 'name of project'
],
```

### Basic Usage


```php
<?php

namespace App\Http\Controllers\Auth;


class LoginController
{
   
    public function redirectToProvider()
    {
        return new Log();
    }

}
```