<?php

//Flexix\PrototypeBundle\Util\PathAnalyze
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Flexix\PathAnalyzerBundle\Util;

/**
 * cache
 */
class PathAnalyze {

    protected $applicationPath;
    protected $application;
    protected $entityAlias;
    protected $entityClass;
    protected $entitiesPath;
    protected $entityId;
    protected $entitiesFromPath = [];

    function getEntityId() {
        return $this->entityId;
    }

    function setEntityId($entityId) {
        $this->entityId = $entityId;
    }

    function getEntityClass() {
        return $this->entityClass;
    }

    function setEntityClass($entityClass) {
        $this->entityClass = $entityClass;
    }

    function getEntitiesPath() {
        return $this->entitiesPath;
    }

    function setEntitiesPath($entitiesPath) {
        $this->entitiesPath = $entitiesPath;
    }

    function getApplicationPath() {
        return $this->applicationPath;
    }

    function getEntityAlias() {
        return $this->entityAlias;
    }

    function getApplication() {
        return $this->application;
    }

    function getEntitiesFromPath() {
        return $this->entitiesFromPath;
    }

    function setApplicationPath($applicationPath) {
        $this->applicationPath = $applicationPath;
    }

    function setApplication($application) {
        $this->application = $application;
    }

    function setEntityAlias($entityAlias) {
        $this->entityAlias = $entityAlias;
    }

    function setEntitiesFromPath($entitiesFromPath) {
        $this->entitiesFromPath = $entitiesFromPath;
    }

    function dump() {

        return [
            'applicationPath' => $this->applicationPath,
            'application' => $this->application,
            'entity_alias' => $this->entityAlias,
            'entity_id' => $this->entityId,
            'entity_class' => $this->entityClass,
            'entitiesPath' => $this->entitiesPath,
            'entities_from_path' => $this->entitiesFromPath
        ];
    }

}
