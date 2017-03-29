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

    public function getEntityClass($alias, $namespaces) {
        $this->checkNamespaceExists($namespaces);
        if (array_key_exists($alias, $this->entities[$namespaces])) {
            return $this->entities[$namespaces][$alias];
        } else {
            throw new \Exception(sprintf('There is no class for name: %s', $alias));
        }
    }

    public function getAlias($entityClass, $namespaces) {
        $this->checkNamespaceExists($namespaces);
        $name = array_search($entityClass, $this->entities[$namespaces]);
        if ($name) {
            return $name;
        } else {
            throw new \Exception(sprintf('There is no name for entityClass %s', $entityClass));
        }
    }

    protected function checkNamespaceExists($namespaces) {
        foreach ($namespaces as $namespace) {
            if (!array_key_exists($namespaces, $this->entities)) {
                throw new \Exception(sprintf('There is no namespace: %s', $namespace));
            }
        }
    }

}
