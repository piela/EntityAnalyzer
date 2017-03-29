<?php

namespace TMSolution\PrototypeBundle\Util;

class ConfigurationFactory {

    protected $services = [];
 
    public function getConfig($applicationPath, $entityAlias) {
       
        if (array_key_exists($applicationPath, $this->services) && array_key_exists($entityAlias, $this->services[$applicationPath]))
            return $this->services[$applicationPath][$entityAlias];
        
    }

    public function addConfiguration($service, $applicationPath, $entityAlias) {
       
        $this->services[$applicationPath][$entityAlias] = $service;
        
    }

    protected function load() {
      
        if ($this->loaded == false) {

            foreach ($this->configComponents as $component) {
                if (is_array($component)) {
                    $this->mergeComponents($component);
                } else if (is_object($component) && get_class($component) == "Core\PrototypeBundle\Service\Config") {
                    $this->mergeComponents($component->getConfig());
                } else {
                    throw new \Exception('Bad type of component, you can pass only arrays or Core\PrototypeBundle\Service\Config objects to this class ');
                }
            }
        } else {
            $this->loaded = true;
            return $this->config;
        }
        
    }

    protected function mergeComponents($array) {

        if (is_array($array)) {
            if (empty($this->config)) {
                $this->config = $array;
            } else {

                $this->config = array_replace_recursive($this->config, $array);
            }
        }
    }

    public function merge(array $config) {

        $this->load();
        $this->config = $this->mergeComponents($config);
    }

}
