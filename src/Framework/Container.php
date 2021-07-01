<?php
namespace App\Framework;

class Container
{
    /**
     * @var array
     */
    protected $services = [];

    /**
     * @param $serviceName
     * @param $service
     * @return $this
     */
    public function register($serviceName, $service)
    {
        $this->services[$serviceName] = $service;

        return $this;
    }

    /**
     * @param $serviceName
     * @return mixed|null
     */
    public function get($serviceName)
    {
        if(isset($this->services[$serviceName])){
            return $this->services[$serviceName];
        }

        return null;
    }
}