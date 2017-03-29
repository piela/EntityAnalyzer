<?php

namespace TMSolution\EntityAnalyzerBundle\Service;

class Security {
    
    protected $tokenStorage;
    
    public function __construct($tokenStorage) {
        $this->tokenStorage=$tokenStorage;
    }
    
    
    public function checkAccess($method) {
        
    }
    
    public function checkDomainAccess()
    {
        
    }
    
}
