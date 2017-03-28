<?php

namespace TMSolution\MapperBundle\Util;

/**
 * cache
 */
class EntityMapper {

    protected $entities;

    public function __construct($entities) {
        $this->entities = $entities;
    }

    public function getEntityClass($name, $namespace) {
        $this->checkNamespaceExists($namespace);
        if (array_key_exists($name, $this->entities[$namespace])) {
            return $this->entities[$namespace][$name];
        } else {
            throw new \Exception(sprintf('There is no class for name: %s', $name));
        }
    }

    public function getName($entityClass, $namespace) {
        $this->checkNamespaceExists($namespace);
        $name = array_search($entityClass, $this->entities[$namespace]);
        if ($name) {
            return $name;
        } else {
            throw new \Exception(sprintf('There is no name for entityClass %s', $entityClass));
        }
    }

    protected function checkNamespaceExists($namespace) {
        if (!array_key_exists($namespace, $this->entities)) {
            throw new \Exception(sprintf('There is no namespace: %s', $namespace));
        }
    }

}
