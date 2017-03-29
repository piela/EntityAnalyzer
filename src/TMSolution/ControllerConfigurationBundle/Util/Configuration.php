<?php

namespace TMSolution\ControllerConfigurationBundle\Util;

use TMSolution\ControllerConfigurationBundle\Util\ConfigurationInterface;


class Configuration implements ConfigurationInterface {

    protected $data = [];
    protected $dataItems = [];
    protected $loaded = false;

    public function __construct(/* you can pass many Config objects and/or arrays */) {

        $this->dataItems = func_get_args();
    }

    public function load() {
        if ($this->loaded == false) {
            
            foreach ($this->dataItems as $dataItem) {
            
                if (is_array($dataItem)) {
                    $this->mergeItems($dataItem);
                } else if (is_object($dataItem) && array_key_exists('TMSolution\ControllerConfigurationBundle\Util\ConfigurationInterface', class_implements($dataItem)) ) {
                    $this->mergeItems($dataItem->getData());
                } else {
                    throw new \Exception('Bad type of component, you can pass only arrays or objects implemented TMSolution\ControllerConfigurationBundle\Util\ConfigurationInterface interface ');
                }
            }
        } else {
            $this->loaded = true;
        }
        return $this->data;
    }

    protected function mergeItems($array) {

        if (is_array($array)) {
            
            if (empty($this->data)) {
                $this->data = $array;
            } else {
                $this->data = array_replace_recursive($this->data, $array);
            }
        }
    }

    public function getData() {

        $this->load();
        return $this->data;
    }

    public function merge(array $data) {

        $this->load();
        $this->data = $this->mergeItems($data);
    }

    public function get($property) {
        $this->load();
        $propertyArr = explode('.', $property);
        $result = null;
       
        foreach ($propertyArr as $value) {
           
            if (!$result) {
                $result = $this->data[$value];
            } else {
                $result = $result[$value];
            }
        }
        return $result;
    }

    public function has($property) {
        $this->load();
        $propertyArr = explode('.', $property);

        $result = null;
        
        foreach ($propertyArr as $value) {
            
            if (!$result) {
                if (isset($this->data[$value])) {
                    $result = $this->data[$value];
                }
            } else {

                if (isset($result[$value])) {
                    $result = $result[$value];
                }
            }
        }

        if ($result != null) {
            return true;
        }
    }

}
