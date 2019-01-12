<?php

declare(strict_types=1);

namespace Marussia\HttpKernel\Managers\RouterManager;

use Marussia\Components\Router\Router as Router;

class RouterManager
{
    private $router;
    
    private $route;

    public function __construct(Router $router)
    {
        $this->router = $router;
    }
    
    public function run($request)
    {
        $this->router->run($request->getUri());
        
        $this->eventBus->eventDispatch('Kernel.Request', 'RouterReady', $this->router->getRoute());
    }
}
