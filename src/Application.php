<?php

namespace App;

use Pimple\Container;
use Zend\Json\Server\Server;
use Pimple\ServiceProviderInterface;

class Application
{

    private $container;

    public function __construct(array $settings)
    {
        $this->container = new Container();
        $this->container['config'] = $settings;
        $this->container[Server::class] = new Server();
    }

    public function setClass($class) {
        $server = $this->container[Server::class];
        $server->setClass($class);
    }


    public function run() {
        $server = $this->container[Server::class];
        $server->handle();
    }

    public function register(ServiceProviderInterface $provider) {
        $this->container->register($provider);
    }

    public function getContainer() {
        return $this->container;
    }
}
