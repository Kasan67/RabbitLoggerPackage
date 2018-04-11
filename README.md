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

You will also need to add credentials in your `config/services.php` configuration file. For example:

```php
'rabbit_logger' => [
    'host' => 'your-rabbit-host',
    'port' => 'your-rabbit-port',
    'user' => 'your-rabbit-user-name',
    'password' => 'your-rabbit-user-password',
    'exchange' => 'your-rabbit-exchange',
    'queue' => 'your-rabbit-queue',
    'key' => 'your-rabbit-key',
    'facility' => 'project-path-from-github'
],
```


To handle all application errors, you need to add to the file `app/Exceptions/Handler.php` these lines in the method :

```php

use kashirin\rabbit_mq\Log;
    
public function render($request, Exception $exception)
    {
        //init and configure logger
        $config = config('services.rabbit_log');
        $logger =  new Log($config);
        $logger->error($exception);
        
        return parent::render($request, $exception);
    }

```

To handle all application requests and responses, you need to add to the file `app/Http/Kernel.php` this line. Recommended use its in block HTTP middlewares, but you can use it in any block.

```php

protected $middleware = [
        // Other app middlewares...
        
        \kashirin\rabbit_mq\Middlewares\ResponseHandlerMiddleware::class,
    ];

```

### Basic Usage

In any place of application you can use Logger with type of methods from [PSR-3 standard](https://www.php-fig.org/psr/psr-3/)

```php
use Illuminate\Http\Request;
use kashirin\rabbit_mq\Log;
    
        
/**
 * Class IndexController
 * @package App\Http\Controllers
 */
class IndexController extends Controller
{
    /**
     * @param Request $request
     * @param Log $log
     * @return array
     * @throws \AMQPChannelException
     * @throws \AMQPConnectionException
     * @throws \AMQPExchangeException
     */
    public function index(Request $request, Log $log)
    {
       $response = [];
       
       //some logic
        
       //simply message log
       $log->info('message to log');
        
       try {
           $data = 'some logic';
       } catch (Exception $exception) {
           //log any Throwable error or exception
           $log->error($exception);
       }
    
       //this type of logs except to use Response and Request objects from Laravel. Used in middleware.
       $log->log($response, $request);
    
       //log any JsonSerializable data
       $log->debug($data);
    
       return $response;
    }
} 
```

