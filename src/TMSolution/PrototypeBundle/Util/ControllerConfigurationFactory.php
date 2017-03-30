<?php

namespace TMSolution\PrototypeBundle\Util;

use TMSolution\PrototypeBundle\Util\ControllerConfiguration;
use TMSolution\ConfigurationBundle\Util\ConfigurationInterface;
use TMSolution\PrototypeBundle\Util\RequestAnalyzerInterface;
use Symfony\Component\HttpFoundation\Request;

class ControllerConfigurationFactory {
    
    const BASE_CONFIG='base';
    const REQUEST_ANALYZE='requestAnalyze';

    protected $services = [];
    protected $config;
    protected $requestAnalyzer;

    public function __construct(ConfigurationInterface $config, RequestAnalyzerInterface $requestAnalyzer) {

        $this->config = $config;
        $this->requestAnalyzer = $requestAnalyzer;
    }

    public function createConfig(Request $request,ConfigurationInterface $controllerConfiguration, $action) {

        $analyze = $this->requestAnalyzer->analyze($request);

        $applicationPath = $analyze->getApplicationPath();
        $entityAlias = $analyze->getEntityAlias();
        $entityClass = $analyze->getEntityClass();

        if (array_key_exists($applicationPath, $this->services) && array_key_exists($entityAlias, $this->services[$applicationPath])) {
            $this->config->merge($this->services[$applicationPath][$entityAlias]);
        }

        $analzyeConfig[[self::REQUEST_ANALYZE] = json_decode(json_encode($analyze), true)
        $controllerConfiguration->merge($config->get[self::BASE_CONFIG]);
        return new ControllerConfiguration(, $config->get[$action],$analzyeConfig );
    }

    public function addConfiguration($service, $applicationPath, $entityAlias) {

        $this->services[$applicationPath][$entityAlias] = $service;
    }

}
