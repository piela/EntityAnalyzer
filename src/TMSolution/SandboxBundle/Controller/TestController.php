<?php

namespace TMSolution\SanboxBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\DependencyInjection\ContainerInterface;
use TMSolution\ControllerConfigurationBundle\Util\ControllerConfigurationFactory;


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


        $request = new Request([], [/* post */], [
            'applicationPath' => 'admin/ala/ma/kota',
            'entitiesPath' => 'product-category'
        ]);
        
        
        

        $response=$this->get('tm_solution_prototype.prototype_controller')->newAction($request);
        $response2=$this->get('tm_solution_prototype.prototype_controller')->getAction($request,6);
        $response3=$this->get('tm_solution_prototype.prototype_controller')->editAction($request,6);
        $response4=$this->get('tm_solution_prototype.prototype_controller')->listAction($request,6);
        
        
        
        return $this->render('default/test.html.twig', array(
                    'editForm1' => $response->getContent(),
                    'editForm2' => $response2->getContent(),
                    'editForm3' => $response3->getContent(),
                    'editForm4'=>$response4->getContent()
        ));
    }

}
