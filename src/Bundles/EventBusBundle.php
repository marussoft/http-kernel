<?php

declare(strict_types=1);

namespace Marussia\HttpKernel\Bundles;

use Marussia\EventBus\Bus;
use Marussia\Request\Request;
use Marussia\HttpKernel\Config;
use Marussia\HttpKernel\Contracts\KernelBundleInterface;

class EventBusBundle implements KernelBundleInterface
{
    private $bus;

    private $config;
    
    public function __construct(Bus $bus, Config $config)
    {
        $this->bus = $bus;
        $this->config = $config;
    }
    
    public function handle(Request $request) : void
    {
        
    }
}
