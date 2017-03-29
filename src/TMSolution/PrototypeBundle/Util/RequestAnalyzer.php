<?php

namespace TMSolution\PrototypeBundle\Util;

class RequestAnalyzer {

    const APPLICATION_PATH = 'applicationPath';
    const ENTITIES_PATH = 'entitiesPath';
    const DELIMETER = '/';
    
    protected $request;
    protected $applicationMapper;
    protected $entityMapper;

    public function __construct($applicationMapper, $entityMapper) {
        $this->applicationMapper = $applicationMapper;
        $this->entityMapper = $entityMapper;
    }

    public function analyze($request) {
        $requestAnalyze = new RequestAnalyze();
        $applicationPath = $request->request->get(self::APPLICATION_PATH);
        $requestAnalyze->setApplicationPath($applicationPath);
        $entitiesPath = $request->request->get(self::ENTITIES_PATH);
        $requestAnalyze->setEntityPath($this->getApplication());
        $requestAnalyze->setEntityAlias($this->getEntityAlias($entitiesPath));
        return $requestAnalyze;
    }

    protected function getApplication($applicationPath) {
        $applicationPathArr = explode(self::DELIMETER, $applicationPath);
        return $applicationPathArr[0];
    }
    
    protected function getEntityAlias($entitiesPath) {
        $applicationPathArr = explode(self::DELIMETER, $entitiesPath);
        return end($applicationPathArr);
    }
    
    protected function getNamespace($application) {
       return  $this->applicationMapper->getNamespaces($application);
    }
    
    protected function getEntityClass($entityAlias,$namespaces) {   
       return  $this->entityMapper->getClassName($entityAlias,$namespaces);
    }

}
