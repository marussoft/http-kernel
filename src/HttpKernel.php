<?php

declare(strict_types=1);

namespace Marussia\HttpKernel;

use Marussia\Request\Request;

class HttpKernel extends AbstractKernel
{
    public function handle(Request $request) : Response
    {
        $result = $this->routeBuilder->resolve($request);
    
        if ($this->extensionCollector->extensionsIsExists()) {
            $extensions = $this->extensionCollector->getExtensions();
            foreach($extensions as $extension) {
                $extension->handle($request);
            }
        }
    
        $this->bus->handle($result)->run($request);
        
        return $this->response();
    }
}
