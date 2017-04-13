<?php

namespace Flexix\PrototypeBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Flexix\PrototypeBundle\DependencyInjection\Compiler\ConfigurationPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class FlexixPrototypeBundle extends Bundle
{
   
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new ConfigurationPass());
    }
    
}
