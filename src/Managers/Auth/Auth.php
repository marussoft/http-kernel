<?php

declare(strict_types=1);

namespace Marussia\HttpKernel\Managers\Auth;

use Marussia\HttpKernel\App as App;
use Marussia\Authorization\Authorization as Authorization;
use Marussia\DependencyInjection\Container as Container;

class Auth
{
    public function init($request)
    {
        $container = new Container;
        
        $auth = $container->instance(Authorization::class, [MASTER_KEY]);
        
        if ($auth->isAuth()) {
            $data = $auth->getData();
        } else {
            $data['role'] = 'guest';
            $data['uid'] = 0;
            $data['gid'] = $auth->getGuestId();
        }

        App::event('App.Auth', 'Ready', $data);
    }
}
