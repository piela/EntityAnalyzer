<?php

namespace TMSolution\EntityAnalyzerBundle\Service;

use Symfony\Component\HttpFoundation\Request;

//chłopak od brudnej roboty ->wylicza serwisy
class RequestInterpreter {

    protected $request;
    protected $mapper;

    public function __construct($mapper) {
        $this->mapper = $mapper;
    }

    public function interprete(Request $request) {
        $requestInterpreation = new RequestInterpretation($request);
        $requestInterpreation->setApplicationName($this->calculateApplicationName($request));
        $requestInterpreation->setEntityClass($this->calculateEntityClass($request));
        $requestInterpreation->setServiceAddress($this->calculateServiceAddress($request));
        $requestInterpreation->setState($this->calculateState());
        return $requestInterpreation;
    }

    function calculateApplicationName(Request $request) {
        //$request->get
        
    }

    function calculateEntityClass(Request $request) {
        //$request->get
    }

    function calculateServiceAddress(Request $request) {
        //$request->get
    }

    function calculateState(Request $request) {
        //$request->get
    }

}
