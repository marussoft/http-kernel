<?php

declare(strict_types=1);

namespace Marussia\HttpKernel;

use Marussia\HttpKernel\Managers\EventManager as EventBus;

class Config
{
    private static $layers;
    
    private static $eventBus;
    
    public function __construct(EventBus $event_bus)
    {
        static::$eventBus = $event_bus;
    }
    
    public static function register(string $type, string $name, string $layer, string $handler = '')
    {
        return static::$eventBus->register($type, $name, $layer, $handler)
    }
    
    public function initMembers(array $layers)
    {
        foreach ($layers as $layer) {
            require_once(ROOT . '/app/Config/' . $layer . '.members.php');
        }
    }
    
    public function getDefaultRoute()
    {
        $route['controller'] = CONTROLLER;
        $route['action'] = ACTION;
        
        return $route;
    }
}
