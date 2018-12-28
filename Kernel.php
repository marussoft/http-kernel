<?php

declare(strict_types=1);

namespace Marussia\HttpKernel;

use Marussia\Components\DependensyInjection as Container;
use Marussia\HttpKernel\Managers\EventManager as Bus;
use Marussia\HttpKernel\Managers\RequestManager as Request;
use Marussia\HttpKernel\Managers\RouterManager as Router;
use Marussia\HttpKernel\Managers\TaskManager as TaskManager;
use Marussia\HttpKernel\Managers\FilterManager as Filter;

class Kernel
{
    private $container;

    private $request;
    
    private $bus;
    
    
    public function __construct()
    {
        $this->container = new Container;
    }
    
    public function init()
    {
        $this->initBus();

        $this->initRequest();
    }
    
    private function initBus()
    {
        $this->bus = $this->container->instance(Bus::class);
    
        $this->bus->setHandler()
    }
    
    private function initRequest()
    {
        $this->request = $this->container->instance(Request::class);
        
        $this->request->resolve();
    }
}
