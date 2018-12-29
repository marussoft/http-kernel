<?php

declare(strict_types=1);

namespace Marussia\HttpKernel\Managers\EventManager;

use Marussia\Components\DependencyInjection\Container as Container;
use Marussia\Components\EventBus\Dispatcher as Dispatcher;
use Marussia\HttpKernel\Managers\FilterManager\FilterManager as Filter;

class EventManagerInterface
{
    private $dispatcher;

    public function __construct(Dispatcher $dispatcher)
    
    public function register(string $type, string $name, string $layer, string $handler = '')
    
    public function eventDispatch(string $subject, string $event, $event_data = null)
    
    public function addLayer(string $layer)
    
    public function setHandler($handler, string $method)
} 
