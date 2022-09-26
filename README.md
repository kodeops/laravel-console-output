```
 _     _  _____  ______  _______  _____   _____  _______
 |____/  |     | |     \ |______ |     | |_____] |______
 |    \_ |_____| |_____/ |______ |_____| |       ______|
 
```
 

# Laravel Console Output

## Installation

`$ composer require kodeops/laravel-console-output`

## Usage

Add singleton to `App\Providers\AppServiceProvider`

```
use kodeops\LaravelConsoleOutput\ConsoleOutput;

public function register()
{
    ...
    $this->app->bind('console', ConsoleOutput::class);
    ...
}
```
