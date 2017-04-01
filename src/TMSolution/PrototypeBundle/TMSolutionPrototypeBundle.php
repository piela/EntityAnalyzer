<?php

namespace TMSolution\PrototypeBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use TMSolution\PrototypeBundle\DependencyInjection\Compiler\ConfigurationPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class TMSolutionPrototypeBundle extends Bundle
{
   
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new ConfigurationPass());
    }
    
}
