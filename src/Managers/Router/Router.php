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
        
        $this->router = $container->instance(RouterHandler::class);
        
        $this->router->setRoutesPath(ROOT . '/app/Routes/');
        
        $this->config = $config;
    }
    
    public function run($request)
    {
        $this->router->run($request->getUri());
        
        $this->router->setMethod($request->getMethod());
        
        $map = $this->router->getMap();
        
        if (empty($map)) {
            $map = $this->config->getDefaultRoute();
        }

        App::event('App.Router', 'RouterReady', $map);
    }
}
