<?php

namespace TMSolution\GeneratorBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('TMSolutionGeneratorBundle:Default:index.html.twig');
    }
}
