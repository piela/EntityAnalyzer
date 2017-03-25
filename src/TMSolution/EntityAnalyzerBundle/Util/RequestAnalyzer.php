<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace TMSolution\EntityAnalyzerBundle\Util;

/**
 * cache
 */
class RequestAnalyzer {

    protected $request;
    public function __construct($request) {
        $this->request=$request;
    }
    
    public function analyze()
    {
        $request->request->get('application');
        $request->request->get('path');
    }
    
    protected function analyzePath()
    {
        //explode
        //return pathArray;
            //class
            //object
            //id
        
    }
}
