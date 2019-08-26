<?php

declare(strict_types=1);

namespace Marussia\HttpKernel\Bundles;

use Marussia\Request\Request;
use Marussia\Router\Router;
use Marussia\HttpKernel\Contracts\KernelBundleInterface;
use Marussia\HttpKernel\Config;

class RequestBundle implements KernelBundleInterface
{
    private $request;
    
    private $router;
    
    private $config;

    public function handle(Request $request)
    {
        $this->request = $request;
        
        $this->router = Router::create(
            $this->request->getUri(), 
            $this->request->getMethod(), 
            $this->request->server->get('HTTP_HOST'), 
            $this->request->isMethod('https') ? 'https' : 'http'
        );
        $this->router->setRoutesDirPath(Config::get('kernel.router', 'routes_dir_path'));
        
        return $this->router->startRouting();
    }
}

