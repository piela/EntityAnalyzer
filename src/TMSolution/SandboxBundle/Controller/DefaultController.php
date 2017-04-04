<?php

namespace TMSolution\SandboxBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('TMSolutionSandboxBundle:Default:index.html.twig');
    }
}
