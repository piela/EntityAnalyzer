<?php

namespace TMSolution\PrototypeBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/configuration.html}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('tm_solution_prototype');

        $rootNode->children()
                        ->booleanNode('debug')
                            ->defaultValue(true)
                            ->end()
                        ->arrayNode('base')
                            ->useAttributeAsKey('name')
                            ->prototype('array')
                                ->useAttributeAsKey('name') 
                                        ->prototype('scalar')
                                        ->end()    
                            ->end()    
                        ->end()
                        ->arrayNode('actions')
                                ->useAttributeAsKey('name')
                                ->prototype('array')
                                    ->useAttributeAsKey('name')
                                        ->prototype('variable')
                                        ->end()
                                ->end()
                        ->end();

        return $treeBuilder;
    }
}
