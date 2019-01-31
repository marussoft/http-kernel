<?php

declare(strict_types=1);

namespace Marussia\HttpKernel\Managers\Response; 

class Response
{
    private $content;
    
    public function send(string $view)
    {
        echo $view;
    }
}
