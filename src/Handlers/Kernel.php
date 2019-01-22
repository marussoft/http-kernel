<?php

declare(strict_types=1);

namespace Marussia\HttpKernel\Handlers;

use Marussia\DependencyInjection\Container as Container;

class Kernel
{
    private $conatiner;
    
    private $manager;
    
    public function __construct()
    {
        $this->container = new Container;
    }
    
    public function run($task)
    {
        $class_name = 'Marussia\HttpKernel\Managers\\' . $task->name() . '\\' . $task->name();
        
        if (!$this->container->has($class_name)) {
            $this->container->instance($class_name);
        }
        
        call_user_func_array([$this->container->get($class_name), $task->action()], [$task->data()]);
    }
    
    public function getContainer()
    {
        return $this->container;
    }
}
