<?php

declare(strict_types=1);

namespace Marussia\HttpKernel;

use Marussia\DependencyInjection\Container as Container;

class App
{
    private static $kernel;
    
    private static $container;
    
    // Запускает приложение
    public static function initKernel() : HttpKernel
    {
        if (static::$container === Container::class) {
            throw new \Exception('Application has been runed!');
        }
        static::$container = new Container;
        static::$kernel = static::$container->instance(HttpKernel::class);
        
        // Инициализация сервисов ядра
        // ...
        
        // Инициализируем ядро
        return static::$kernel;
    }
    
    // Передает полученное событие в ядро
    public static function event(string $subject, string $event, $event_data = null)
    {
        static::$kernel->event($subject, $event, $event_data);
    }
    
    // Передает полученное команду в ядро
    public static function command(string $member, string $action, $data)
    {
        static::$kernel->serviceCommand($member, $action, $data);
    }
    
    // Создает новую подписку для участника
    public static function subscribe(string $member, string $subject, string $action, array $condition = [])
    {
        static::$kernel->subscribe($member, $subject, $action, $condition);
    }
    
    public static function view(string $name, array $data)
    {
        static::$kernel->view($name, $data);
    }

}
