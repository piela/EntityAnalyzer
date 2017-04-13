<?php

//Flexix\PathAnalyzerBundle\Util\PathAnalyzer

namespace Flexix\PathAnalyzerBundle\Util;

use Flexix\PathAnalyzerBundle\Util\PathAnalyzerInterface;

class PathAnalyzer implements PathAnalyzerInterface {


    const DELIMETER = '/';
    const ID = 'id';
    const ENTITIES_LIMIT = 10;

    protected $request;
    protected $applicationMapper;
    protected $entityMapper;

    public function __construct($applicationMapper, $entityMapper) {
        $this->applicationMapper = $applicationMapper;
        $this->entityMapper = $entityMapper;
    }

    public function analyze($applicationPath,$entitiesPath,$id=null) {

            $pathAnalyze = new PathAnalyze();

            //$applicationPath = $request->attributes->get(self::applicationPath);
            //$entitiesPath = $request->attributes->get(self::entitiesPath);
           //if ($applicationPath && $entitiesPath) {
           //  throw new \Exception(sprintf('No "%s" parameter in Request attributes', self::applicationPath));
            $entityAlias = $this->getEntityAlias($entitiesPath);
            $application = $this->getApplication($applicationPath);
            $bundles = $this->getBundles($application);
            $entityClass = $this->getEntityClass($entityAlias, $bundles);
            $entittiesFromPath = $this->getEntitiesFromPath($id, $entitiesPath, $bundles);
            $pathAnalyze->setApplicationPath($applicationPath);
            $pathAnalyze->setApplication($application);
            $pathAnalyze->setEntitiesPath($entitiesPath);
            $pathAnalyze->setEntitiesFromPath($entittiesFromPath);
            $pathAnalyze->setEntityAlias($entityAlias);
            $pathAnalyze->setEntityClass($entityClass);
            $pathAnalyze->setEntityId($id);
        //}
        return $pathAnalyze;
    }

    protected function getApplication($applicationPath) {

        $applicationPathArr = explode(self::DELIMETER, $applicationPath);

        return $applicationPathArr[0];
    }

    protected function getEntityAlias($entitiesPath) {

        $entitiesPath = explode(self::DELIMETER, $entitiesPath);

        return end($entitiesPath);
    }

    protected function getBundles($application) {

        return $this->applicationMapper->getBundles($application);
    }

    protected function getEntityClass($entityAlias, $bundles) {

        return $this->entityMapper->getEntityClass($entityAlias, $bundles);
    }

    protected function getValidId($id) {
        if (is_numeric($id)) {
            return $id;
        } else {
            throw new \Exception('Entity id must by numeric');
        }
    }

    protected function getEntitiesFromPath($id, $entitiesPath, $bundles) {

        $entities = [];
        $entitiesPathArr = explode(self::DELIMETER, $entitiesPath);
        $entitiesArr = array_chunk($entitiesPathArr, 2);
        $entitiesNumber = count($entitiesArr);
        $counter = 0;

        if (self::ENTITIES_LIMIT >= $entitiesNumber) {
            foreach ($entitiesArr as $entityArr) {

                $counter++;
                $entity = [];
                $entity['alias'] = $entityArr[0];
                $entity['entity_class'] = $this->getEntityClass($entityArr[0], $bundles);

                if ($counter == $entitiesNumber) {
                    $entity['id'] = $id;
                } else {
                    $entity['id'] = $this->getValidId($entityArr[1]);
                }

                $entities[] = $entity;
            }

            return $entities;
        } else {
            throw new \Exception('Entities limit exceeded. EntitiesPath is to long');
        }
    }

}
