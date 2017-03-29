<?php

namespace TMSolution\PrototypeBundle\Util;

use TMSolution\PrototypeBundle\Util\ControllerConfiguration;

class ControllerConfigurationFactory {

    protected $services = [];
    protected $baseConfig;
    
    public function __construct($baseConfig,$requestAnalyzer) {
        $this->baseConfig=$baseConfig;;
        $this->requestInterpreter=$requestAnalyzer;
    }
    
    public function createConfig($request,$action) {
      
        $interpretation=$requestInterpreter->analyze($request);
        $applicationPath=$interpretation->getApplicationPath();
        $entityAlias=$interpretation->getEntityAlias();
        $entityClass=$this->mapper->getEntityClass($entityAlias);

        
        if (array_key_exists($applicationPath, $this->services) && array_key_exists($entityAlias, $this->services[$applicationPath]))
        {
            $config->merge($this->services[$applicationPath][$entityAlias]);    
        }
        return new ControllerConfiguration($config->get['base'],$config->get[$action],["entity"=>$entityClass]);
    }

    public function addConfiguration($service, $applicationPath, $entityAlias) {
       
        $this->services[$applicationPath][$entityAlias] = $service;
        
    }

 

}
