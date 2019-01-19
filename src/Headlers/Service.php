<?php

declare(strict_types=1);

namespace Marussia\HttpKernel\Handlers;

use Marussia\Components\DependencyInjection\Container as Container;

class Service
{
    private $conatiner;
    
    public function __construct()
    {
        $this->container = new Container;
    }
    
    public function run()
    {
    
    }
} 
