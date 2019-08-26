<?php

declare(strict_types=1);

namespace Marussia\HttpKernel;

use Marussia\DependencyInjection\Container;
use Marussia\HttpKernel\Exceptions\KernelConfigIsNotInitializedException;

class ExtensionCollector extends Container
{
    private $extensionsBinds = [];

    public function __construct(Config $config)
    {
        if (!$config->isReady()) {
            throw new KernelConfigIsNotInitializedException();
        }
    
        $this->set(Config::class, $config);
        
        $this->extensionBinds = $config->getAll('kernel.extensions');
    }

    public function getExtensions() : array
    {
        $extensions = [];
    
        foreach($this->extensionsBinds as $extensionName => $class) {
            $extensions[$extensionName] = $this->instance($class);
        }
        
        return $extensions;
    }
    
    public function extensionsIsExists() : bool
    {
        return !empty($this->extensionsBinds);
    }
}
