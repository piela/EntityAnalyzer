<?php

namespace TMSolution\GeneratorBundle\Util;
/**
 * Description of Generator
 *
 * @author Mariusz
 */
class Generator {
    //put your code here
    
    
    protected $engine;

  
    public function __construct($engine) {
        
        $this->engine=$engine;
        
    }
    
    public function generate($template,$data)
   {
       return $this->engine->render($template,$data);
        
   }
    
    
}
