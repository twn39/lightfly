<?php

namespace App;

use Pimple\Container;
use Zend\Json\Server\Server;
use Pimple\ServiceProviderInterface;

class Application
{
    /**
     * @var Container
     */
    private $container;

    /**
     * Application constructor.
     *
     * @param array $settings
     */
    public function __construct(array $settings)
    {
        $this->container = new Container();
        $this->container['config'] = $settings;
        $this->container[Server::class] = new Server();
    }

    /**
     * @param $class
     */
    public function setClass($class)
    {
        $server = $this->container[Server::class];
        $server->setClass($class)
            ->setReturnResponse(true);
    }

    /**
     *
     */
    public function run()
    {
        $auth = $this->container[Auth::class];
        $error = $auth->check($this->getRequest(), $this->container['config']['auth']);
        if ($error) {
            echo $error;
            return;
        }

        $server = $this->container[Server::class];
        $response = $server->handle();
        echo $response;
    }

    /**
     * @param ServiceProviderInterface $provider
     */
    public function register(ServiceProviderInterface $provider)
    {
        $this->container->register($provider);
    }

    /**
     * @return Container
     */
    public function getContainer()
    {
        return $this->container;
    }

    /**
     * @return mixed
     */
    public function getRequest()
    {
        return $this->container[Server::class]->getRequest();
    }
}
