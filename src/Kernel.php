<?php

declare(strict_types=1);

namespace Marussia\HttpKernel;

use Marussia\DependencyInjection\Container as Container;
use Marussia\HttpKernel\Bus\Bus as Bus;
use Marussia\HttpKernel\Managers\Request\Request as Request;
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
        $this->bus->eventDispatch('App.Kernel', 'Ready');
    }

    // Передает событие в шину
    public function event(string $subject, string $event, $event_data = null)
    {
        $this->bus->eventDispatch($subject, $event, $event_data);
    }
    
    // Обрабатывает полученую команду
    public function serviceCommand(string $member, string $action, $data = null)
    {
        if (preg_match('(^Service\.)', $member)) {
            $this->command($member, $action, $data);
        }
    }
    
    // Создает новую подписку для участника
    public function subscribe(string $member, string $subject, string $action, array $condition = [])
    {
        // Получаем участника из шины
        $bus_member = $this->config->getMember($member);
        
        // Создаем подписку
        $bus_member->subscribe($subject, $action, $condition);
    }
    
    public function view($name, $data)
    {
        $this->command('App.Template', 'data', [$name => $data]);
    }
    
    // Обрабатывает полученую команду
    private function command(string $member, string $action, $data = null)
    {
        // Получаем участника из шины
        $bus_member = $this->config->getMember($member);
        
        // Создаем задачу
        $task = $bus_member->createTask($action);
        
        $task->setData($data);
        
        // Передаем в обработчик
        $this->bus->command($task);
    }
}
