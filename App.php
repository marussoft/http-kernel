<?php

declare(strict_types=1);

namespace Marussia\HttpKernel;

use Marussia\Components\DependensyInjection as Container;

class App
{
    private static $kernel;
    
    public static start(Container $container)
    {
        if ($container->has(Kernel::class) {
            return;
        }
        static::$kernel = $container->instance(Kernel::class);
        static::$kernel->init();
    }
}
