<?php

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
    protected $entityPath;
    protected $entitiesFromPath = [];

    function getApplicationPath() {
        return $this->applicationPath;
    }

    function getEntityAlias() {
        return $this->entityAlias;
    }

    function getApplication() {
        return $this->application;
    }

    function getEntityPath() {
        return $this->entityPath;
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

    function setEntityPath($entityPath) {
        $this->entityPath = $entityPath;
    }

    function setEntitiesFromPath($entitiesFromPath) {
        $this->entitiesFromPath = $entitiesFromPath;
    }

}
