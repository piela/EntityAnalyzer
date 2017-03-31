<?php

namespace TMSolution\ControllerConfigurationBundle\Util;

use TMSolution\ControllerConfigurationBundle\Util\ControllerConfiguration;
use TMSolution\ControllerConfigurationBundle\Exception\NoConfigurationForActionException;
use TMSolution\ConfigurationBundle\Util\ConfigurationInterface;
use TMSolution\RequestAnalyzerBundle\Util\RequestAnalyzerInterface;
use Symfony\Component\HttpFoundation\Request;


class ControllerConfigurationFactory {

    const BASE_CONFIG = 'base';
    const REQUEST_ANALYZE = 'requestAnalyze';

    protected $configurations = [];
    protected $config;
    protected $requestAnalyzer;

    public function __construct(ConfigurationInterface $config, RequestAnalyzerInterface $requestAnalyzer) {

        $this->config = $config;
        $this->requestAnalyzer = $requestAnalyzer;
    }

    public function createConfiguration(Request $request, ConfigurationInterface $controllerConfiguration, $action) {
   
         
        $analyze = $this->requestAnalyzer->analyze($request);

        $applicationPath = $analyze->getApplicationPath();
        $entityAlias = $analyze->getEntityAlias();
        $entityClass = $analyze->getEntityClass();

        $this->mergeConfigurations($applicationPath, $entityAlias);
        
        $baseSection=$this->getBaseSection();
        $actionSection=$this->getActionSection($action);
        $analyzeSection=$this->getAnalyzeSection($analyze);
        
        
        $controllerConfiguration->merge($baseSection,$actionSection,$analyzeSection );
        
        dump($controllerConfiguration);
    
       // $controllerConfiguration->setAction($action);
        return $controllerConfiguration;
    }
    
    protected function getBaseSection()
    {
        return $this->config->get(self::BASE_CONFIG);
    }

    protected function getAnalyzeSection($analyze) {
        
        $analzyeConfig = [];
        $analzyeConfig[self::REQUEST_ANALYZE] = json_decode(json_encode($analyze), true);
        return $analzyeConfig;
        
    }
    protected function mergeConfigurations($applicationPath, $entityAlias) {

        $configuration = $this->findSpecializedConfiguration($applicationPath, $entityAlias);
        if ($configuration) {
            $this->config->merge($configuration);
        }
        return $this->config;
    }

    protected function getActionSection($action) {
    
        $actionAddress = sprintf('actions.%s', $action);
        if ($this->config->has($actionAddress)) {
     
            return $this->config->get($actionAddress);
        } else {
            
            throw new NoConfigurationForActionException(sprintf('There is no configuration for action: %s', $action));
        }
    }

    protected function findSpecializedConfiguration($applicationPath, $entityAlias) {

        if (array_key_exists($applicationPath, $this->configurations) && array_key_exists($entityAlias, $this->configurations[$applicationPath])) {

            return $this->configurations[$applicationPath][$entityAlias];
        }
    }

    public function addConfiguration(ConfigurationInterface $cofniguration, $applicationPath, $entityAlias) {

        $this->configurations[$applicationPath][$entityAlias] = $cofniguration;
    }

}
