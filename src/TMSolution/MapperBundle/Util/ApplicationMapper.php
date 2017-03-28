<?php

namespace TMSolution\MapperBundle\Util;

/**
 * cache
 */
class ApplicationMapper {

    protected $applications;

    public function __construct($applications) {
        $this->applications = $applications;
    }

    public function getNamepaces($name) {
        $this->checkApplicationExists($name);
        if (!is_array($this->applications[$name])) {
            $array = [];
            $array[] = $this->applications[$name];
            return $array;
        } else {
            return $this->applications[$name];
        }
    }

    protected function checkApplicationExists($name) {
        if (!array_key_exists($name, $this->applications)) {
            throw new \Exception(sprintf('There is no application: %s', $name));
        }
    }

}
