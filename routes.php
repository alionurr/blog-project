<?php

use Symfony\Component\Yaml\Yaml;
$routes = Yaml::parse(file_get_contents('config/routes.yaml'));

$requestUri = $_SERVER["REQUEST_URI"];
$controller = 'DefaultController';
$params = [];
$method = 'notfoundAction';
foreach ($routes as $route => $rule){
    if(isset($rule['params'])){
        $ruleParams = $rule['params'];
        $ruleParamsKeys = array_keys($ruleParams);
        $ruleParamsValues = array_values($ruleParams);
        $route = str_replace($ruleParamsKeys, $ruleParamsValues, $route);
    }
    $pattern = "/".str_replace("/", "\/", $route)."$/";
    preg_match($pattern, $requestUri, $matches);
    if(!empty($matches)){
        $controller = $rule["controller"];
        $method = $rule["method"];
        if(count($matches) > 1){
            $params = array_slice($matches, 1);
        }
        break;
    }
}