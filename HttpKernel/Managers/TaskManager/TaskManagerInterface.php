<?php

declare(strict_types=1);

namespace Marussia\HttpKernel\Managers\TaskManager;

use Marussia\Components\DependencyInjection\Container as Container;
use Marussia\Components\TaskManager\TaskManager as Manager;
use Marussia\HttpKernel\Config as Config;

interface TaskManagerInterface
{
    public function __construct(Config $config)
    
    public function init()
    
    public function run($task)

}
 
