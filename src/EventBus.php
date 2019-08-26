<?php

declare(strict_types=1);

namespace Marussia\HttpKernel;

use Marussia\EventBus\Bus;
use Marussia\HttpKernel\Config;

class EventBusBundle
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
