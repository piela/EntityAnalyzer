<?php

namespace TMSolution\MapperBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration.
 *
 * @link http://symfony.com/doc/current/cookbook/bundles/extension.html
 */
class TMSolutionMapperExtension extends Extension {

    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container) {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        if (!array_key_exists('enitites', $config)) {
            $config['entities'] = [];
        }

        $container->setParameter('tm_solution_mapper.entities', $config['entities']);

        if (!array_key_exists('applications', $config)) {
            $config['applications'] = [];
        }

        $container->setParameter('tm_solution_mapper.applications', $config['applications']);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yml');
    }

}
