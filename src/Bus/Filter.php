<?php

declare(strict_types=1);

namespace Marussia\HttpKernel\Bus;

use Marussia\Components\DependencyInjection\Container as Container;
use Marussia\Components\Filter\Filter as Filter;
use Marussia\HttpKernel\Config as Config;
use Marussia\HttpKernel\Bus\Tasks as TaskManager;

class Filter
{
    private $config;
    
    private $filter;
    
    private $container;
    
    private $taskManager;
    
    public function __construct(Config $config, TaskManager $task_manager)
    {
        $this->container = new Container;
    
        $this->config = $config;
        
        $this->taskManager = $task_manager;
    }
    
    public function init()
    {
        $filters = $this->config->getFilters();
        
        $this->filter = $this->container->instance(Filter::class, [$this->taskManager]);
    }
    
    // Запускает фильтрацию задачи
    public function run($task) : void
    {
        $this->filter->run($task);
    }
}
