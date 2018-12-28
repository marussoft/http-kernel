<?php

declare(strict_types=1);

namespace Marussia\HttpKernel\Managers;

use Marussia\Components\EventBus\Dispatcher as Dispatcher;

class EventManager implements EventManagerInterface;
{
    private $dispatcher;
    
    private $filterManager;

    public function __construct(Dispatcher $dispatcher, FilterManager $filter_manager)
    {
        $this->dispatcher = $dispatcher;
        
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
