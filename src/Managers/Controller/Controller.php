<?php

declare(strict_types=1);

namespace Marussia\HttpKernel\Managers\Controller;

use Marussia\Components\DependencyInjection\Container as Container;

class Controller;
{
    private $conatiner;
    
    public function __construct()
    {
        $this->container = new Container;
    }

    public function runController(array $request)
    {
        $class_name = 'App\Controllers\\' . $request['controller'] . '\\Actions\\' . $request['action'];
        
        $controller = $this->container->instance($class_name, [$request]);
        
        $controller->run();
    }
}
