<?php

namespace App\Providers;

use App\Auth;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class AppProvider implements ServiceProviderInterface
{
    /**
     * @param Container $container
     */
    public function register(Container $container)
    {
        $container[Auth::class] = new Auth();
        $container['auth'] = $container[Auth::class];
    }
}
