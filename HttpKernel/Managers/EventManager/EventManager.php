<?php

declare(strict_types=1);

namespace Marussia\HttpKernel\Managers\EventManager;

use Marussia\Components\DependencyInjection\Container as Container;
use Marussia\Components\EventBus\Dispatcher as Dispatcher;
use Marussia\HttpKernel\Managers\FilterManager\FilterManager as Filter;

class EventManager implements EventManagerInterface;
{
    private $dispatcher;
    
    private $filterManager;
    
    private $container;

    public function __construct(Filter $filter_manager)
    {
        $this->container = new Container;
        
        $this->dispatcher = $this->container->instance(Dispatcher::class);
        
        $this->filterManager = $filter_manager;
    }
    
    public function init()
    {
        $this->dispatcher->setHandler($this->filterManager);
    }
    
    public function register(string $type, string $name, string $layer, string $handler = '')
    {
        return $this->dispatcher->register($type, $name, $layer, $handler);
    }
    
    public function eventDispatch(string $subject, string $event, $event_data = null)
    {
        $this->dispatcher->dispatch($subject, $event, $event_data);
    }
    
    public function addLayer(string $layer)
    {
        $this->dispatcher->addLayer($layer);
    }
}
