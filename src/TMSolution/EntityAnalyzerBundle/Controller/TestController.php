<?php

namespace TMSolution\EntityAnalyzerBundle\Controller;

use TMSolution\EntityAnalyzerBundle\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Prototype controller.
 * 
 */
class PrototypeController extends Controller {

    
    public function newAction(Request $request) {
        
        $this->get('prototype.controller')->newAction($request);
        $this->get('prototype.controller')->listAction($request);
     
        
    }

    
}
