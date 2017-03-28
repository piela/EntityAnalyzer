<?php

namespace TMSolution\MapperBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/configuration.html}
 */
class Configuration implements ConfigurationInterface {

    public function getConfigTreeBuilder() {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('tm_solution_mapper');
         $rootNode
        ->children()
            ->variableNode('applications')
            ->end()     
            ->arrayNode('entities')
                ->useAttributeAsKey('name')
                ->prototype('array')
                    ->useAttributeAsKey('name')
                        ->prototype('scalar')
                    ->end()
                ->end()
            ->end()
        ->end();
        return $treeBuilder;
    }

}
