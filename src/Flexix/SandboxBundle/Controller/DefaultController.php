<?php

namespace Flexix\SandboxBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('FlexixSandboxBundle:Default:index.html.twig');
    }
}
