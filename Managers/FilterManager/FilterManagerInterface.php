<?php

declare(strict_types=1);

namespace Marussia\HttpKernel\Managers\FilterManager;

use Marussia\Components\DependensyInjection as Container;
use Marussia\Components\Filter\Filter as Filter;
use Marussia\HttpKernel\Config as Config;
use Marussia\HttpKernel\Managers\TaskManager\TaskManager as TaskManager;

interface FilterManagerInterface
{
    private $config;
    
    private $filter;
    
    private $container;
    
    private $taskManager;
    
    public function __construct(Config $config, TaskManager $task_manager)
    
    public function init() : void
    
    // Запускает фильтрацию задачи
    public function run($task) : void
} 
