<?php

declare(strict_types=1);

namespace Marussia\HttpKernel\Bus;

use Marussia\Components\DependencyInjection\Container as Container;
use Marussia\Components\EventBus\Dispatcher as Dispatcher;
use Marussia\HttpKernel\Bus\Filter as Filter;

class Dispatcher implements DispatcherInterface;
{
    private $dispatcher;
    
    private $filter;
    
    private $container;

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
    
    public function eventDispatch(string $subject, string $event, $event_data = null)
    {
        $this->dispatcher->dispatch($subject, $event, $event_data);
    }
    
    public function addLayer(string $layer)
    {
        $this->dispatcher->addLayer($layer);
    }
}
