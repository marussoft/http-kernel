<?php

declare(strict_types=1);

namespace Marussia\HttpKernel\Managers\TaskManager;

use Marussia\Components\DependencyInjection\Container as Container;
use Marussia\Components\TaskManager\TaskManager as Manager;
use Marussia\HttpKernel\Config as Config;

class TaskManager implements TaskManagerInterface
{
    private $container;
    
    private $config;
    
    private $taskManager;
    
    public function __construct(Config $config)
    {
        $this->container = new Container;
        
        $this->config = $config;
    }
    
    public function init()
    {
        $handlers = $this->config->getHandlers();
        
        $this->taskManager = $this->container->instance(Manager::class, [$handlers]);
    }
    
    public function run($task)
    {
        $this->taskManager->run($task);
    }
}
