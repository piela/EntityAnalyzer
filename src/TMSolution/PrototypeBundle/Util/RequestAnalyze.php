<?php

//TMSolution\PrototypeBundle\Util\RequestAnalyze
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace TMSolution\PrototypeBundle\Util;


/**
 * cache
 */
class RequestAnalyze {

    protected $applicationPath;
    protected $application;
    protected $entityAlias;
    protected $entityClass;
    protected $entitiesPath;
    protected $entitiesFromPath = [];

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

}
