<?php

namespace Flexix\ConfigurationBundle\Util;

use Flexix\ConfigurationBundle\Util\ConfigurationInterface;

class Configuration implements ConfigurationInterface {

    protected $data = [];

    public function __construct($data = []) {

        $this->checkType($data);
        $this->data = $this->assimilateData($data);
    }

    public function merge() {

        $dataItems = func_get_args();

        foreach ($dataItems as $data) {

            $this->checkType($data);
            $data = $this->assimilateData($data);

            if (empty($this->data)) {
                $this->data = $data;
            } else {
                $this->data = array_replace_recursive($this->data, $data);
            }
        }
        return $this;
    }

    protected function assimilateData($data) {
        if (is_object($data) && array_key_exists('Flexix\ConfigurationBundle\Util\ConfigurationInterface', class_implements($data))) {
            $data = $data->getData();
        }
        return $data;
    }

    protected function checkType($data) {
        if (is_array($data) || (is_object($data) && array_key_exists('Flexix\ConfigurationBundle\Util\ConfigurationInterface', class_implements($data)))) {

            return true;
        } else {
            throw new \Exception('Argument must be an array or implements Flexix\ConfigurationBundle\Util\ConfigurationInterface');
        }
    }

    public function getData() {

        return $this->data;
    }

    public function get($property) {

        $propertyArr = explode('.', $property);
        $result = null;

        $result = $this->data;

        foreach ($propertyArr as $value) {

            if (array_key_exists($value,$result)) {
                $result = $result[$value];
            } else {
                throw new \Exception(sprintf('Property \'%s\' doesn\'t exists in configuration', $property));
            }
        }

        return $result;
    }

    public function has($property) {

        $propertyArr = explode('.', $property);

        $result = $this->data;

        foreach ($propertyArr as $value) {

            if (array_key_exists($value,$result)) {
                $result = $result[$value];
            } else {
                return false;
            }
        }

        return true;
    }

}
