<?php

declare(strict_types=1);

namespace Marussia\HttpKernel;

use Marussia\DependencyInjection\Container as Container;

class App
{
    private static $kernel;

    // Запускает приложение
    public static function initKernel(Config $config) : HttpKernel
    {
        if (static::$kernel === HttpKernel::class) {
            throw new ApplicationHasBeenRunedException();
        }
        
        static::$kernel = new Httpkernel(new BundleCollector($config));
        
        // Возвращаем ядро
        return static::$kernel;
    }
    
    public static function view(array $data) : void
    {
        static::$kernel->view($data);
    }
}
