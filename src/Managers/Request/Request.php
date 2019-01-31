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
        $this->request->init();
        
        if ($this->request->getContext() === 'Ajax') {
            App::event('App.Request', 'AjaxRequestReady', $this->request);
        } else {
            App::event('App.Request', 'RequestReady', $this->request);
        }
    }
}
