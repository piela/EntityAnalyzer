<?php

namespace TMSolution\ControllerConfigurationBundle\Util;

use TMSolution\ConfigurationBundle\Util\ConfigurationInterface;
use TMSolution\RequestAnalyzerBundle\Util\RequestAnalyzerInterface;

//@to do: change mergin model
interface ControllerConfigurationFactoryInterface {

    public function createConfiguration( ConfigurationInterface $controllerConfiguration, $action,$applicationPath,$entitiesPath,$id=null);
    
    public function addConfiguration(ConfigurationInterface $configuration, $applicationPath, $entityAlias);

}
