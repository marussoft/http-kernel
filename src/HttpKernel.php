<?php

declare(strict_types=1);

namespace Marussia\HttpKernel;

use Marussia\Request\Request;

class HttpKernel extends AbstractKernel
{
    private $bundleCollector;
    
    private const RESOLVER_NAME = 'RequestBundle';
    
    private const EVENT_BUS_NAME = 'EventBusBundle';
    
    private const RESPONSE_NAME = 'ResponseBundle';
    
    public function __construct(BundleCollector $bundleCollector)
    {
        $this->bundleCollector = $bundleCollector;
    }
    
    // Обрабатывает запрос
    public function handle(Request $request) : Response
    {
        $this->bundleCollector->getBundle(self::RESOLVER_NAME)->handle($request);
    
        if ($this->bundleCollector->extensionsIsExists()) {
            $extensions = $this->bundleCollector->getExtensions();
            foreach($extensions as $extension) {
                $extension->handle($request);
            }
        }
    
        $this->bundleCollector->get(self::EVENT_BUS_NAME)->handle($request);
        
        return $this->bundleCollector->getBundle(self::RESPONSE_NAME);
    }
    
    public function view(array $data)
    {
        $this->bundleCollector->getBundle(self::RESPONSE_NAME)->view($data);
    }
}
