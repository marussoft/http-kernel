<?php

declare(strict_types=1);

namespace Marussia\HttpKernel\Base;

abstract class Controller
{
    protected $request;
    
    public function setRequst($request)
    {
        $this->request = $request;
    }
}
