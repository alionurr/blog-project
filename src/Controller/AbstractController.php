<?php


namespace App\Controller;

use App\Framework\Container;
use Symfony\Component\HttpFoundation\Request;

abstract class AbstractController
{
    /**
     * @var Container
     */
    protected $container;


    /**
     * AbstractController constructor.
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function get($serviceName)
    {
        return $this->container->get($serviceName);
    }
    /**
     * @return Request
     */
    public function getRequest(): Request
    {
        return $this->container->get('request');
    }

    /**
     * @return mixed
     */
    public function getEntityManager()
    {
        return $this->container->get('entity_manager');
    }



}