<?php

namespace TMSolution\EntityAnalyzerBundle\Service;

use Symfony\Component\HttpFoundation\Request;

class ConfigFactory {

    protected $mapper;
    protected $requestInterpreter;
    protected $security;
    protected $configuration;
    
    public function __construct($mapper, $requestInterpreter, $security) {
        $this->mapper = $mapper;
        $this->requestInterpreter = $requestInterpreter;
        $this->security = $security;
    }
    
    public function createConfig(Request $request)
    {   
        $interpretaiton=$this->requestInterpreter()->interprete($request);
        return new Config($interpretaiton,$this->mapper,$this->security);
    }
    
}
