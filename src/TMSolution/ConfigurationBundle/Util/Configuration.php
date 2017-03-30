<?php

namespace TMSolution\ConfigurationBundle\Util;

use TMSolution\ConfigurationBundle\Util\ConfigurationInterface;

class Configuration implements ConfigurationInterface {

    protected $data = [];

    public function __construct($data = []) {

        $this->data = $data;
    }

    protected function merge() {

        $dataItems = func_get_args();
        
        foreach ($dataItems as $data) {

            if (is_object($data) && array_key_exists('TMSolution\ConfigurationBundle\Util\ConfigurationInterface', class_implements($data))) {
                $data = $data->getData();
            }
            else if(is_array($data))
            {
                break;
            }
            else
            {
                throw new \Exception('Argument must be an array or implements TMSolution\ConfigurationBundle\Util\ConfigurationInterface');
            }

            if (empty($this->data)) {
                $this->data = $data;
            } else {
                $this->data = array_replace_recursive($this->data, $data);
            }
        }
        return $this;
    }

    public function getData() {

        return $this->data;
    }

    public function get($property) {

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
