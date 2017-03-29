<?php

namespace TMSolution\EntityAnalyzerBundle\Service;

use Symfony\Component\HttpFoundation\Request;

class RequestInterpretation {

    protected $applicationName;
    protected $entityClass;
    protected $serviceAddress;
    protected $state;

    function getApplicationName() {
        return $this->applicationName;
    }

    function getEntityClass() {
        return $this->entityClass;
    }

    function getServiceAddress() {
        return $this->serviceAddress;
    }

    function getState() {
        return $this->state;
    }

    function setApplicationName($applicationName) {
        $this->applicationName = $applicationName;
    }

    function setEntityClass($entityClass) {
        $this->entityClass = $entityClass;
    }

    function setServiceAddress($serviceAddress) {
        $this->serviceAddress = $serviceAddress;
    }

    function setState($state) {
        $this->state = $state;
    }

}
