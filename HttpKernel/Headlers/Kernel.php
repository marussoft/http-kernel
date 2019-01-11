<?php

declare(strict_types=1);

namespace Marussia\HttpKernel\Handlers;

use Marussia\Components\DependencyInjection\Container as Container;

class Kernel
{
    private $conatiner;
    
    public function __construct()
    {
        $this->container = new Container;
    }
    
    public function run($task)
    {
        $class_name = 'Marussia\HttpKernel\Managers\\' . $task->name() . 'Manager';
        
        $manager = $this->container->instance($class_name);
        
        call_user_function_array($manager, $task->action(), [$task->data()]);
    }
    
    public function getContainer()
    {
        return $this->container;
    }
}
