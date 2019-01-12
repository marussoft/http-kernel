<?php

declare(strict_types=1);

namespace Marussia\HttpKernel\Managers\RouterManager;

use Marussia\Components\DependencyInjection\Container as Container;
use Marussia\Components\Router\Router as Router;

class RouterManager
{
    private $router;
    
    private $route;

    public function __construct()
    {
        $container = new Container;
        
        $this->router = $container->instance(Router::class, [ROOT . '/app/Routes/']);
    }
    
    public function run($request)
    {
        $this->router->run($request->getUri());
        
        $this->eventBus->eventDispatch('Kernel.Request', 'RouterReady', $this->router->getRoute());
    }
}
