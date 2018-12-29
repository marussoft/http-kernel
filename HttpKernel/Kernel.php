<?php

declare(strict_types=1);

namespace Marussia\HttpKernel;

use Marussia\Components\DependencyInjection\Container as Container;
use Marussia\HttpKernel\Managers\EventManager\EventManager as Bus;
use Marussia\HttpKernel\Managers\RequestManager\RequestManager as Request;
use Marussia\HttpKernel\Managers\RouterManager\RouterManager as Router;
use Marussia\HttpKernel\Managers\TaskManager\TaskManager as TaskManager;
use Marussia\HttpKernel\Managers\FilterManager\FilterManager as Filter;

class Kernel
{
    private $container;

    private $config;

    private $bus;
    
    private $taskManager;
    
    private $filter;
    
    public function __construct()
    {
        $this->container = new Container;

        $this->bus = $this->container->instance(Bus::class);

        $this->taskManager = $this->container->instance(TaskManager::class);

        $this->filter = $this->container->instance(Filter::class);

        $this->config = $this->container->instance(Config::class);
    }
    
    public function init()
    {
        // Инициализируем шину событый
        $this->bus->init();
        
        // Регистрируем участников
        $this->config->initMembers(['Kernel', 'Controller', 'Service']);
        
        // Инициализируем менеджер фильтров
        $this->filter->init();
        
        // Объявляем о готовности ядра
        $this->$this->bus->eventDispatch('Kernel.Kernel', 'Ready');
    }

    public function event(string $subject, string $event, $event_data = null)
    {
        $this->$this->bus->eventDispatch($subject, $event, $event_data);
    }
    
    public function command(string $member, string $action, $data)
    {
        $member = $this->bus->getMember($member);
        
        $task = $member->getTask($member, $action, $data);
        
        $this->filter->run($task);
    }
}
