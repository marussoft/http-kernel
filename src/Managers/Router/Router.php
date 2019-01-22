<?php

declare(strict_types=1);

namespace Marussia\HttpKernel\Managers\Router;

use Marussia\DependencyInjection\Container as Container;
use Marussia\Router\Router as RouterHandler;
use Marussia\HttpKernel\Config as Config;
use Marussia\HttpKernel\App as App;

class Router
{
    private $router;
    
    private $route;
    
    private $config;

    public function __construct(Config $config)
    {
        $container = new Container;
        
        $this->router = $container->instance(RouterHandler::class, [ROOT . '/app/Routes/']);
        
        $this->config = $config;
    }
    
    public function run($request)
    {
        $this->router->run($request->getUri());
        
        $route = $this->router->getRoute();
        
        if (empty($route)) {
            $route = $this->config->getDefaultRoute();
        }

        App::event('Kernel.Router', 'RouterReady', $route);
    }
}
