<?php

namespace TMSolution\PrototypeBundle\Util;


class RequestAnalyzer {

    const APPLICATION_PATH = 'applicationPath';
    const ENTITY_PATH = 'entityAlias';
    const ENTITY_ALIAS = 'entityPath';
    const DELIMETER = '/';

    protected $request;

    public function __construct() {
       
    }

    public function analyze($request) {
       
        $requestAnalyze=new RequestAnalyze();
        $applicationPath=$request->request->get(self::APPLICATION_PATH);
        $requestAnalyze->setApplicationPath($applicationPath);
        $entityAlias=$request->request->get(self::ENTITY_PATH);
        
        $requestAnalyze->setEntityPath($this->getApplication());
        $requestAnalyze->setEntityAlias($this->getEntityAlias());
        return $requestAnalyze;
    }

    protected function getApplication($applicationPath) {
        $applicationPathArr=explode(self::DELIMETER,$applicationPath);
        return $applicationPathArr[0];
    }

    protected function getEntityAlias($entitiesPath) {
        $applicationPathArr=explode(self::DELIMETER,$applicationPath);
        return end($applicationPathArr);         
    }

}
