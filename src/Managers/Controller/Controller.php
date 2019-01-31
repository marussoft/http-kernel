<?php

declare(strict_types=1);

namespace Marussia\HttpKernel\Managers\Controller;

use Marussia\DependencyInjection\Container as Container;
use Marussia\HttpKernel\App as App;

class Controller
{
    private $container;
    
    private $request;
    
    public function __construct()
    {
        $this->container = new Container;
    }

    public function setRequest($request)
    {
        $this->request = $request;
    }
    
    public function runController(array $route)
    {
        $class_name = 'App\Controllers\\' . $route['controller'] . 'Controller\\' . $route['action'];
        
        $controller = $this->container->instance($class_name);
        
        $this->setRequest($this->request);
        
        $controller->run($route);
        
        App::event('App.Controller', 'Ready');
    }
}
