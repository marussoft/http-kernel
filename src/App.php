<?php

declare(strict_types=1);

namespace Marussia\HttpKernel;

use Marussia\DependencyInjection\Container as Container;

class App
{
    private static $kernel;
    
    // Запускает приложение
    public static function run()
    {
        $container = new Container;
    
        if ($container->has(Kernel::class)) {
            return;
        }
        static::$kernel = $container->instance(Kernel::class);
        
        // Инициализируем ядро
        static::$kernel->init();
    }
    
    // Передает переданное событие в ядро
    public static function event(string $subject, string $event, $event_data = null)
    {
        static::$kernel->event($subject, $event, $event_data);
    }
    
    // Передает переданную команду в ядро
    public static function command(string $member, string $action, $data)
    {
        static::$kernel->command($member, $action, $data);
    }
}
