<?php

declare(strict_types=1);

namespace Marussia\HttpKernel;

use Marussia\HttpKernel\Exceptions\ConfigIsNotFoundException;
use Marussia\HttpKernel\Exceptions\ConfigFileIsNotFoundException;

class Config
{
    private static $instance;

    private $rootPath;
    
    private $configDir;
    
    private $defaultBundlesBinds;

    public function __construct(string $rootPath, string $configDir)
    {
        $this->rootPath = $rootPath;
        
        $this->configDir = $rootPath . '/' . $configDir;
        
        $this->defaultBundleBinds = [
            'RequestBundle' => 'Marussia\HttpKernel\Bundles\RequestResolver',
            'EventBusBundle' => 'Marussia\HttpKernel\Bundles\EventBus',
            'ResponseBundle' => 'Marussia\HttpKernel\Bundles\Response',
        ];
        
        static::$instance = $this;
    }
    
    public function getAll(string $configName) : array
    {
        $configPath = $this->configDir . '/' . str_replace('.', '/', $configName) . '.php';
        if (!is_file($configPath)) {
            throw new ConfigFileIsNotFoundException($configName);
        }
        return include $configPath;
    }
    
    public function getDefaultBundlesBinds() : array
    {
        return $this->defaultBundlesBinds;
    }
    
    public static function get(string $configFile, string $configName) : string
    {
        $configArray = static::$instance->getAll($configFile);
        
        if (!array_key_exists($configName, $configArray)) {
            throw ConfigIsNotFoundException($configName, $configName);
        }
        return $configArray[$configName];
    }
}
