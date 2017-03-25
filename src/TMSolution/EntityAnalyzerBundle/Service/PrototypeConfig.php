<?php

namespace TMSolution\EntityAnalyzerBundle\Service\PrototypeConfig;

class PrototypeConfig {

    protected $request;
    protected $appliaction;
    protected $entityClass;
    protected $container;
    protected $mapper;

    public function __construct($container) {
        $this->container = $container;
    }

    public function getConfig($request) {

        $this->analyzeRequest($request);
        return $this;
    }

    protected function analyzeRequest() {
        
    }

    public function getApplication() {
        
    }

    public function createEntity() {
        
    }

    public function getEntityClass() {

        return $this->getMapper()->getEntityClass($en);
    }

    public function getSearchFormType() {
        
    }

    public function createSearchQuery() {
        
    }

    public function getFormType() {
        
    }

    public function getFormTypeClass() {
        
    }

    public function getModel() {
        $serviceName = sprintf("%s.%s", $this->getApplication(), $this->getEntityClass());
        if ($this->container->has($serviceName)) {
            return $this->container->get($serviceName);
        } else {
            return $this->container->get('model.factory')->getModel($this->getEntityClass());
        }
    }

    public function getTemplate($actionName) {
        
    }

    public function getRedirectStrategy($actionName) {
        
    }

}
