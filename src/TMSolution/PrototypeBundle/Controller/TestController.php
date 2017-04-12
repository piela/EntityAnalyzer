<?php

namespace TMSolution\PrototypeBundle\Controller;

use TMSolution\PrototypeBundle\Controller\PrototypeController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use TMSolution\ControllerConfigurationBundle\Util\ControllerConfigurationFactoryInterface;
use TMSolution\ControllerConfigurationBundle\Util\ControllerConfiguration;
use TMSolution\PrototypeBundle\Util\ControllerDriver;
use FOS\RestBundle\Controller\FOSRestController;

/**
 * Entity controller.
 * 
 */
class TestController extends PrototypeController {

    public function testAction(Request $request) {
     $view = $this->view(null, 200)
       ->setTemplate('menuitem\index.html.twig');
    
       return $this->handleView($view);
    }
}
