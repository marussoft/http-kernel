<?php

declare(strict_types=1);

namespace Marussia\HttpKernel;

use Marussia\Components\DependensyInjection as Container;
use Marussia\HttpKernel\Managers\EventManager as Bus;
use Marussia\HttpKernel\Managers\RequestManager as Request;
use Marussia\HttpKernel\Managers\RouterManager as Router;
use Marussia\HttpKernel\Managers\TaskManager as TaskManager;
use Marussia\HttpKernel\Managers\FilterManager as Filter;

class Kernel
{
    private $container;

    private $config;

    private $bus;
    
    private $taskManager;
    
    public function __construct()
    {
        $this->container = new Container;
        
        $this->bus = $this->container->instance(Bus::class);
        
        $this->config = $this->container->instance(Config::class);
    }
    
    public function init()
    {
        // Инициализируем шину событый
        $this->$this->bus->init();
        
        // Регистрируем участников
        $this->config->initMembers(['Kernel', 'Controller', 'Service']);
        
        // Получаем менеджер задач
        $this->taskManager = $this->container->get(TaskManager::class);
        
        // Объявляем готовность ядра
        $this->$this->bus->eventDispatch('Kernel.Kernel', 'Ready');
    }

}
