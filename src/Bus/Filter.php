<?php

declare(strict_types=1);

namespace Marussia\HttpKernel\Bus;

use Marussia\DependencyInjection\Container as Container;
use Marussia\Filter\Filter as FilterHandler;
use Marussia\HttpKernel\Config as Config;
use Marussia\HttpKernel\Bus\Tasks as Tasks;

class Filter
{
    private $config;
    
    private $filter;
    
    private $container;
    
    private $tasks;
    
    public function __construct(Config $config, Tasks $tasks)
    {
        $this->container = new Container;
    
        $this->config = $config;
        
        $this->tasks = $tasks;
        
        $filters = $this->config->getFilters();
        
        $this->filter = $this->container->instance(FilterHandler::class, [$filters, $this->tasks]);
    }
    
    // Запускает фильтрацию задачи
    public function run($task) : void
    {
        $this->filter->run($task);
    }
}
