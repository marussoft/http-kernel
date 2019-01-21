<?php

declare(strict_types=1);

namespace Marussia\HttpKernel;

use Marussia\DependencyInjection\Container as Container;
use Marussia\HttpKernel\Bus\Bus as Bus;
use Marussia\HttpKernel\Managers\Request\Request as Request;
use Marussia\HttpKernel\Managers\Router\Router as Router;
use Marussia\HttpKernel\Managers\Response\Response as Response;

class Kernel
{
    private $container;

    private $config;

    private $bus;
    
    public function __construct()
    {
        $this->container = new Container;

        $this->config = $this->container->instance(Config::class);
        
        $this->bus = $this->container->instance(Bus::class);
    }
    
    // Инициализирует компоненты ядра
    public function init()
    {
        // Инициализируем шину событый
        $this->bus->init();
        
        // Регистрируем участников
        $this->config->initMembers(['Kernel', 'Service'], $this->bus);
        
        // Объявляем о готовности ядра
        $this->bus->eventDispatch('Kernel.Kernel', 'Ready');
    }

    // Передает событие в шину
    public function event(string $subject, string $event, $event_data = null)
    {
        $this->bus->eventDispatch($subject, $event, $event_data);
    }
    
    // Обрабатывает полученую команду
    public function command(string $member, string $action, $data)
    {
        // Получаем участника из шины
        $member = $this->config->getMember($member);
        
        // Создаем задачу
        $task = $member->getTask($member, $action, $data);
        
        // Передаем в обработчик
        $this->bus->command($task);
    }
}
