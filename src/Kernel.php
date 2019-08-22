<?php

declare(strict_types=1);

namespace Marussia\HttpKernel;

use Marussia\DependencyInjection\Container;
use Marussia\EventBus\Bus;
use Marussia\Request\Request;
use Marussia\Router\Router;
use Marussia\Response\Response;

class Kernel extends Container
{
    private $request;

    private $config;

    private $bus;
    
    private $response;
    
    public function __construct(Bus $bus, Config $config)
    {
        $this->config = $config;
        
        $this->bus = $bus;
    }
    
    // Обрабатывает запрос
    public function handle(Request $request) : Response
    {
        return $this->response;
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
