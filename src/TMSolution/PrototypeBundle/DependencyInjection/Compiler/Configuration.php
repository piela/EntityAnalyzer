<?php

namespace TMSolution\PrototypeBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;

class TransportCompilerPass implements CompilerPassInterface {

    const SERVICE_NAME = 'tm_solution.prototype.configurationFactory';
    const METHOD_NAME = 'addConfiguration';
    const TAG_ID = 'tm_solution.prototype.controller_configuration';
    const APPLICATION_PATH = 'applicationPath';
    const ENTITY_ALIAS = 'entityAlias';

    public function process(ContainerBuilder $container) {

        $taggedServices = $container->findTaggedServiceIds(self::TAG_ID);
        $this->findTaggedServices($taggedServices, $this->getDefinition($container));
    }

    protected function getDefinition(ContainerBuilder $container) {

        if (!$container->hasDefinition(self::SERVICE_NAME)) {
            return;
        }

        return $container->getDefinition(self::SERVICE_NAME);
    }

    protected function findTaggedServices($taggedServices, $definition) {

        foreach ($taggedServices as $id => $tags) {
            $this->addServices($id, $tags, $definition);
        }
    }

    protected function addServices($id, $tags, $definition) {

        foreach ($tags as $attributes) {
            $definition->addMethodCall(self::METHOD_NAME, array(
                new Reference($id),
                $attributes[self::APPLICATION_PATH], $attributes[self::ENTITY_ALIAS]
            ));
        }
    }

}
