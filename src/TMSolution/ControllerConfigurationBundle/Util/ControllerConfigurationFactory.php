<?php

namespace TMSolution\ControllerConfigurationBundle\Util;

use TMSolution\ConfigurationBundle\Util\ConfigurationInterface;
use TMSolution\RequestAnalyzerBundle\Util\RequestAnalyzerInterface;
use Symfony\Component\HttpFoundation\Request;

//@to do: change mergin model
class ControllerConfigurationFactory {

    const BASE_CONFIG = 'base';
    const REQUEST_ANALYZE = 'requestAnalyze';

    protected $configurations = [];
    protected $baseConfiguration;
    protected $configuration;
    protected $requestAnalyzer;

    public function __construct(ConfigurationInterface $baseConfig, RequestAnalyzerInterface $requestAnalyzer) {

        $this->baseConfiguration = $baseConfig;
        $this->requestAnalyzer = $requestAnalyzer;
    }

    public function createConfiguration(Request $request, ConfigurationInterface $controllerConfiguration, $action) {

        $this->configuration=$controllerConfiguration;
        
        $analyze = $this->requestAnalyzer->analyze($request);
        $analyzeSection = $this->getAnalyzeSection($analyze);
        
        $applicationPath = $analyze->getApplicationPath();
        $entityAlias = $analyze->getEntityAlias();

        $this->mergeToConfiguration($this->baseConfiguration, $action);
        $this->mergeConfigurations($applicationPath, $entityAlias,$action);

        $this->configuration->merge($analyzeSection);
        $controllerConfiguration->setAction($action);

        return $controllerConfiguration;
    }
    
    protected function mergeToConfiguration($configuration, $action)
    {
        $baseSection = $this->getBaseSection($configuration);
        $actionSection = $this->getActionSection($configuration,$action);
        return $this->mergeSections($baseSection,$actionSection);
    }

    protected function mergeSections() {
        
        $sections=func_get_args();
        foreach($sections as $section)
        {
            if($section)
            {
                $this->configuration->merge($section);
            }
            
        }
        return $this->configuration;
    }

    protected function getBaseSection($configuration) {

        if ($configuration->has(self::BASE_CONFIG)) {
            return $configuration->get(self::BASE_CONFIG);
        }
    }

    protected function getActionSection($configuration, $action) {

        $actionAddress = sprintf('actions.%s', $action);
        if ($configuration->has($actionAddress)) {
            return $configuration->get($actionAddress);
        }
    }

    protected function getAnalyzeSection($analyze) {

        $analyzeConfiguration = [];
        $analyzeConfiguration[self::REQUEST_ANALYZE] =  $analyze->getProperties();

        return $analyzeConfiguration;
    }

    protected function mergeConfigurations($applicationPath, $entityAlias,$action) {

        $configuration = $this->findSpecializedConfiguration($applicationPath, $entityAlias);
        if ($configuration) { 
            $this->mergeToConfiguration($configuration, $action);
        }
        return $this->configuration;
    }

    protected function findSpecializedConfiguration($applicationPath, $entityAlias) {

        if (array_key_exists($applicationPath, $this->configurations) && array_key_exists($entityAlias, $this->configurations[$applicationPath])) {

            return $this->configurations[$applicationPath][$entityAlias];
        }
    }

    public function addConfiguration(ConfigurationInterface $configuration, $applicationPath, $entityAlias) {

        $this->configurations[$applicationPath][$entityAlias] = $configuration;
    }

}
