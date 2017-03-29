<?php

namespace TMSolution\PrototypeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('TMSolutionPrototypeBundle:Default:index.html.twig');
    }
}
