<?php

declare(strict_types=1);

namespace Marussia\HttpKernel;

use Marussia\DependencyInjection\Container;
use Marussia\HttpKernel\Contracts\KernelBundleInterface as Bundle;
use Marussia\HttpKernel\Exceptions\BundleIsNotFoundException;
use Marussia\HttpKernel\Exceptions\KernelConfigIsNotInitializedException;

class BundleCollector extends Container
{
    private $bundlesBinds = [];
    
    private $extensionBundlesBinds = [];

    public function __construct(Config $config)
    {
        if (!$config->isReady()) {
            throw new KernelConfigIsNotInitializedException();
        }
    
        $this->set(Config::class, $config);
    
        $this->bundlesBinds = $config->getDefaultBundlesBinds();
        
        $externalBundles = $config->getAll('kernel.bundles');
        
        foreach($externalBundles as $bundleName => $class) {
            if (!empty($class)) {
                $this->bundlesBinds[$bundleName] = $class;
            }
        }
        
        $this->extensionBundlesBinds = $config->getAll('kernel.extensions');
    }
    
    public function getBundle(string $bundleName) : Bundle
    {
        if (!array_key_exists($bundleName, $this->bundlesBinds)) {
            throw new BundleIsNotFoundException($bundleName);
        }
        
        $this->instance($this->bundlesBinds[$bundleName]);
        
        return $this->get($bundleName);
    }

    public function getExtensions() : array
    {
        $extensionBundles = [];
    
        foreach($this->extensionBundlesBinds as $bundleName => $class) {
            $extensionBundles[$bundleName] = $this->instance($this->bundlesBinds[$class]);
        }
        
        return $extensionBundles;
    }
    
    public function extensionsIsExists() : bool
    {
        return !empty($this->extensionBundlesBinds);
    }
}
