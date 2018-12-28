<?php

declare(strict_types=1);

namespace Marussia\HttpKernel\Managers;

use Marussia\Components\EventBus\Dispatcher as Dispatcher;

class EventManager
{
    private $dispatcher;

    public function __construct(Dispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }
    
    public function eventDispatch(string $subject, string $event, $event_data = null)
    {
        $this->dispatcher->dispatch($subject, $event, $event_data);
    }
}
