<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace TMSolution\EntityAnalyzerBundle\Util;

/**
 * cache
 */
class ClassMapper {

    protected $names;
    protected $entityCalsses;

    public function __construct($path) {
        $this->readMap($path);
    }

    protected function readMap() {
        return $this->map;
    }

    public function getEntityClass($name) {
        if (array_key_exists($name, $this->names)) {
            $this->names[$name];
        } else {
            throw new \Exception(sprintf('There is no class for name: %s', $name));
        }
    }

    public function getName($entityClass) {
        if (array_key_exists($entityClass, $this->entityClasses)) {
            $this->names[$entityClass];
        } else {
            throw new \Exception(sprintf('There is no name for entityClass %s', $entityClass));
        }
    }

}
