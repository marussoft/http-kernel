<?php

declare(strict_types=1);

namespace Marussia\HttpKernel\Bus;

use Marussia\DependencyInjection\Container as Container;
use Marussia\EventBus\Dispatcher as Dispatcher;
use Marussia\HttpKernel\Bus\Filter as Filter;

class Bus
{
    private $dispatcher;
    
    private $filter;
    
    private $container;
    
    private $tasks;

    public function __construct(Filter $filter)
    {
        $this->container = new Container;
        
        $this->dispatcher = $this->container->instance(Dispatcher::class);
        
        $this->filter = $filter;
    }
    
    public function init()
    {
        $this->dispatcher->setHandler($this->filter);
    }
    
    public function register(string $type, string $name, string $layer, string $handler = '')
    {
        return $this->dispatcher->register($type, $name, $layer, $handler);
    }
    
    public function eventDispatch(string $subject, string $event, $event_data = [])
    {
        $this->dispatcher->dispatch($subject, $event, $event_data);
    }
    
    public function addLayer(string $layer)
    {
        $this->dispatcher->addLayer($layer);
    }
    
    public function command($task)
    {
        $this->filter->run($task);
    }
}
