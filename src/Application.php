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

    public function setClass($class)
    {
        $server = $this->container[Server::class];
        $server->setClass($class)
            ->setReturnResponse(true);
    }

    public function handle()
    {
        $server = $this->container[Server::class];
        return $server->handle();
    }

    public function register(ServiceProviderInterface $provider)
    {
        $this->container->register($provider);
    }

    public function getContainer()
    {
        return $this->container;
    }

    public function getRequest()
    {
        return $this->container[Server::class]->getRequest();
    }
}
