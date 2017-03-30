<?php

namespace TMSolution\MapperBundle\Util;

use TMSolution\MapperBundle\Exceptions\MoreThanOneEntityClassForAliasException;
use TMSolution\MapperBundle\Exceptions\NoAliasForEntityClassException;
use TMSolution\MapperBundle\Exceptions\NoEntityClassForAliasException;
use TMSolution\MapperBundle\Exceptions\NoBundleException;
/**
 * cache
 */
class EntityMapper {

    protected $entities;

    public function __construct($entities) {
        $this->entities = $entities;
    }

    public function getEntityClass($alias, $bundles) {

        $this->checkNamespaceExists($bundles);
        $results = [];

        foreach ($bundles as $bundle) {
            $result = $this->findEntityClass($alias, $bundle);

            if ($result) {
                $results[] = $result;
            }
        }

        $count = count($results);

        if ($count == 0) {
            throw new NoEntityClassForAliasException(sprintf('There is no entityClass for alias: %s', $alias));
        } else if ($count > 1) {
            throw new MoreThanOneEntityClassForAliasException(sprintf('There is more than one entityClass for alias: %s - %s', $alias, implode(',', $results)));
        } else {
            return $results[0];
        }
    }

    protected function findEntityClass($alias, $bundle) {

        foreach ($this->entities[$bundle] as $map) {
            if ($map['alias'] == $alias) {
                return $map['entityClass'];
            }
        }
    }

    public function getAlias($entityClass, $bundles) {

        $this->checkNamespaceExists($bundles);
        $results = [];

        foreach ($bundles as $bundle) {
            $result = $this->findAlias($entityClass, $bundle);

            if ($result) {
                $results[] = $result;
            }
        }

        $count = count($results);

        if ($count == 0) {
            throw new NoAliasForEntityClassException(sprintf('There is no alias for entityClass: %s', $entityClass));
        }
        else {
            return $results[0];
        }
    }

    protected function findAlias($entityClass, $bundle) {

        foreach ($this->entities[$bundle] as $map) {
            
            if ($map['entityClass'] == $entityClass) {
                return $map['alias'];
            }
        }
    }

    protected function checkNamespaceExists($bundles) {

        foreach ($bundles as $bundle) {

            if (!array_key_exists($bundle, $this->entities)) {
                throw new NoBundleException(sprintf('There is no bundle: %s', $bundle));
            }
        }
    }

}
