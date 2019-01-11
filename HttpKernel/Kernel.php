<?php

declare(strict_types=1);

namespace Marussia\HttpKernel;

use Marussia\Components\DependencyInjection\Container as Container;
use Marussia\HttpKernel\Managers\EventManager\EventManager as Bus;
use Marussia\HttpKernel\Managers\RequestManager\RequestManager as Request;
use Marussia\HttpKernel\Managers\RouterManager\RouterManager as Router;
use Marussia\HttpKernel\Managers\TaskManager\TaskManager as TaskManager;
use Marussia\HttpKernel\Managers\FilterManager\FilterManager as Filter;
use Marussia\HttpKernel\Managers\ResponseManager\ResponseManager as Response;

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
    
    // Инициализирует компоненты ядра
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

    // Передает событие в шину
    public function event(string $subject, string $event, $event_data = null)
    {
        $this->$this->bus->eventDispatch($subject, $event, $event_data);
    }
    
    // Обрабатывает полученую команду
    public function command(string $member, string $action, $data)
    {
        // Получаем участника из шины
        $member = $this->bus->getMember($member);
        
        // Создаем задачу
        $task = $member->getTask($member, $action, $data);
        
        // Передаем в обработчик
        $this->filter->run($task);
    }
}
