<?php

declare(strict_types=1);

namespace Marussia\HttpKernel\Managers\Request;

use Marussia\Request\Request as RequestHandler;
use Marussia\HttpKernel\App as App;

class Request
{
    private $eventBus;
    
    private $request;

    public function __construct(RequestHandler $request)
    {
        $this->request = $request;
    }
    
    public function run()
    {
        if ($this->request->getContext() === 'Ajax') {
            App::event('Kernel.Request', 'AjaxRequestReady', $this->request);
        } else {
            App::event('Kernel.Request', 'RequestReady', $this->request);
        }
    }
}
