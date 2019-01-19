<?php

declare(strict_types=1);

namespace Marussia\HttpKernel\Managers\RequestManager;

use Marussia\Components\Request\Request as Request;

class RequestManager
{
    private $eventBus;
    
    private $request;

    public function __construct(Request $request EventManager $event_bus)
    {
        $this->eventBus = $event_bus;
        
        $this->request = $request;
    }
    
    public function run()
    {
        if ($this->request->getContext() === 'Ajax') {
            $this->eventBus->eventDispatch('Kernel.Request', 'AjaxRequestReady', $this->request);
        } else {
            $this->eventBus->eventDispatch('Kernel.Request', 'RequestReady', $this->request);
        }
    }
}
