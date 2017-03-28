<?php

namespace TMSolution\SampleEntitiesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('TMSolutionSampleEntitiesBundle:Default:index.html.twig');
    }
}
