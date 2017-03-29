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

    public function getEntityClass($alias, $namespace) {
        $this->checkNamespaceExists($namespace);
        if (array_key_exists($alias, $this->entities[$namespace])) {
            return $this->entities[$namespace][$alias];
        } else {
            throw new \Exception(sprintf('There is no class for name: %s', $alias));
        }
    }
    
    public function getAlias($entityClass, $namespace) {
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
