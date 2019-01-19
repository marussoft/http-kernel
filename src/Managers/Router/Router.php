<?php

declare(strict_types=1);

namespace Marussia\HttpKernel\Managers\Router;

use Marussia\Components\DependencyInjection\Container as Container;
use Marussia\Components\Router\Router as Router;

class Router
{
    private $router;
    
    private $route;
    
    private $config;

    public function __construct(Config $config)
    {
        $container = new Container;
        
        $this->router = $container->instance(Router::class, [ROOT . '/app/Routes/']);
        
        $this->config = $config;
    }
    
    public function run($request)
    {
        $this->router->run($request->getUri());
        
        $route = $this->router->getRoute();
        
        if (empty($route)) {
            $route = $this->config->getDefaultRoute();
        }
        
        $this->eventBus->eventDispatch('Kernel.Request', 'RouterReady', $route);
    }
}
