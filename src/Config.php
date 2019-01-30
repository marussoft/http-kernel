<?php

declare(strict_types=1);

namespace Marussia\HttpKernel;

class Config
{
    private static $layers;
    
    private static $eventBus;
    
    private static $members;
    
    public static function register(string $type, string $name, string $layer, string $handler = '')
    {
        return static::$members[$type . '.' . $name] = static::$eventBus->register($type, $name, $layer, $handler);
    }
    
    public function initMembers(array $layers, $event_bus)
    {
        static::$eventBus = $event_bus;

        foreach ($layers as $layer) {
            require_once(ROOT . '/app/Config/' . strtolower($layer) . '.members.php');
            
            static::$eventBus->addLayer($layer);
        }
    }
    
    public function getDefaultRoute()
    {
        $route['controller'] = CONTROLLER;
        $route['action'] = ACTION;
        
        return $route;
    }
    
    public function getFilters()
    {
        return require_once(ROOT . '/app/Config/filters.php');
    }
    
    public function getHandlers()
    {
        return require_once(ROOT . '/app/Config/handlers.php');
    }
    
    public function getMember($member)
    {
        return static::$members[$member];
    }
}
