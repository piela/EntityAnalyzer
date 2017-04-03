<?php

namespace TMSolution\PrototypeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\DependencyInjection\ContainerInterface;
use TMSolution\ControllerConfigurationBundle\Util\ControllerConfigurationFactory;
use TMSolution\ControllerConfigurationBundle\Util\ControllerConfiguration;
use TMSolution\PrototypeBundle\Util\ControllerDriver;

/**
 * Prototype controller.
 * 
 */
class TestController extends Controller {

    protected $configurationFactory;

    public function __construct(ContainerInterface $container = null, ControllerConfigurationFactory $configurationFactory) {
        $this->container = $container;
        $this->configurationFactory = $configurationFactory;
    }

    public function testAction(Request $request) {


        $requestA = new Request([], [/* post */], [
            'applicationPath' => 'admin/ala/ma/kota',
            'entitiesPath' => 'product-category'
        ]);
        
        

        $response=$this->get('tm_solution_prototype.prototype_controller')->newAction($requestA);
        
        
        
        return $this->render('default/test.html.twig', array(
                    'editForm1' => $response->getContent(),
                    'editForm2' => $response->getContent()
        ));
    }

}
