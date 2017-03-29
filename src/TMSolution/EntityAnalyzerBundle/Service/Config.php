<?php

namespace TMSolution\EntityAnalyzerBundle\Service;

use Symfony\Component\HttpFoundation\Request;

class Config {

    protected $mapper;
    protected $requestInterpreter;
    protected $security;
    protected $request;
    protected $configuration;

    public function __construct(Request $request, $mapper, $requestInterpreter, $security) {
        $this->request=$request;
        $this->mapper = $mapper;
        $this->requestInterpreter = $requestInterpreter;
        $this->security = $security;
    }

//  
//    public function getSecurity() {
//        return $this->security;
//    }
//
//    public function getRequestInterpreter() {
//        return $this->requestInterpreter;
//    }


//    public function getApplication() {
//        
//    }

//    public function createEntity() {
//        
//    }

//    public function getEntityClass() {
//        return $this->getMapper()->getEntityClass('ala', 'aaaa');
//    }

    public function getSearchFormType() {
        
    }

//    public function createSearchQuery() {
//        
//    }

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
