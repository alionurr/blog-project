<?php


namespace App\Framework;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Yaml\Yaml;

class SecurityHandler
{
    /**
     * @var array
     */
    protected $firewalls = [];

    /**
     * @var array
     */
    protected $accessControlList = [];

    public function run(Request $request)
    {
         $this->compile();
         $this->handle($request);
    }

    protected function compile()
    {
        $securityConfigFile = __DIR__ . '/../../config/security.yaml';
        if(!file_exists($securityConfigFile)){
            return;
        }
        $securityConfigs = Yaml::parse(file_get_contents($securityConfigFile));
        if(isset($securityConfigs['security'])){
            $securityConfigValues = $securityConfigs['security'];
            $this->setFirewalls($securityConfigValues);
            $this->setAccessControl($securityConfigValues);
        }
    }
    protected function handle(Request $request)
    {
        foreach ($this->accessControlList as $accessControlRule){
            if(isset($accessControlRule['path'])){
               $path = $accessControlRule['path'];
               var_dump(preg_quote($path,'/'));
               var_dump($request->getRequestUri());
               preg_match('/'.preg_quote($path,'/').'/', $request->getRequestUri(), $matches);
               var_dump($matches);
            }
        }
        exit;
    }


    protected function setFirewalls($securityConfigValues)
    {
        if(isset($securityConfigValues['firewalls'])){
            $firewalls = $securityConfigValues['firewalls'];
            foreach ($firewalls as $firewallName => $firewall){
                $this->firewalls[$firewallName] = $firewall;
            }
        }
    }

    protected function setAccessControl($securityConfigValues)
    {
        if(isset($securityConfigValues['access_control'])){
            $this->accessControlList = $securityConfigValues['access_control'];
        }
    }
}