<?php

declare(strict_types=1);

namespace Marussia\HttpKernel\Managers\Auth;

use Marussia\HttpKernel\App as App;

class Auth
{
    public function init($request)
    {
        App::event('Kernel.Auth', 'Ready');
    }
}
