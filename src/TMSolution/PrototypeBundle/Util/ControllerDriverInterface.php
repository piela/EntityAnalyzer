<?php

namespace TMSolution\PrototypeBundle\Util;


class ControllerDriverInterface {

  
    public function isActionAllowed();

    public function getEntityClass(); 
    
    public function getApplicationPath();
    
    public function getEntitiesPath(); 
    
    public function returnResultToView();
    
    public function getResultParameter();
    
    public function shouldRedirect();
        
    public function getRedirectRoute($arguments);
    
    public function getModel();

    public function getFormTypeClass();

    public function getTemplate(); 

    
}
