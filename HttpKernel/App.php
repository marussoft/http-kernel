<?php

declare(strict_types=1);

namespace Marussia\HttpKernel;

use Marussia\Components\DependencyInjection\Container as Container;

class App
{
    private static $kernel;
    
    public static function run(Container $container)
    {
        if ($container->has(Kernel::class) {
            return;
        }
        static::$kernel = $container->instance(Kernel::class);
        
        // Инициализируем ядро
        static::$kernel->init();
        
        // Возвращаем ответ
        static::$kernel->sendResponse();
    }
    
    public static function event(string $subject, string $event, $event_data = null)
    {
        static::$kernel->event($subject, $event, $event_data);
    }
    
    public static function command(string $member, string $action, $data)
    {
        static::$kernel->command($member, $action, $data);
    }
}
