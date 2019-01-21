<?php

declare(strict_types=1);

namespace Marussia\HttpKernel\Bus;

use Marussia\DependencyInjection\Container as Container;
use Marussia\EventBus\Dispatcher as Dispatcher;
use Marussia\HttpKernel\Bus\Filter as Filter;

class BusInterface
{
    private $dispatcher;

    public function __construct(Dispatcher $dispatcher)
    
    public function register(string $type, string $name, string $layer, string $handler = '')
    
    public function eventDispatch(string $subject, string $event, $event_data = null)
    
    public function addLayer(string $layer)
    
    public function setHandler($handler, string $method)
} 
