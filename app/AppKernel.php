<?php

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = [
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
            new AppBundle\AppBundle(),
            new Flexix\EntityAnalyzerBundle\FlexixEntityAnalyzerBundle(),
            new Flexix\MapperBundle\FlexixMapperBundle(),
            new Flexix\SampleEntitiesBundle\FlexixSampleEntitiesBundle(),
            new Flexix\PrototypeBundle\FlexixPrototypeBundle(),
            new Flexix\ConfigurationBundle\FlexixConfigurationBundle(),
            new Flexix\ControllerConfigurationBundle\FlexixControllerConfigurationBundle(),
            new FOS\RestBundle\FOSRestBundle(),
            new JMS\SerializerBundle\JMSSerializerBundle(),
           
           
            new Flexix\ModelBundle\FlexixModelBundle(),
            new Flexix\SandboxBundle\FlexixSandboxBundle(),
            new Flexix\GeneratorBundle\FlexixGeneratorBundle(),
            new Flexix\FormTypeTemplatesBundle\FlexixFormTypeTemplatesBundle(),
            new Flexix\WizardBundle\FlexixWizardBundle(),
            
            new Nelmio\ApiDocBundle\NelmioApiDocBundle(),
            new Lexik\Bundle\FormFilterBundle\LexikFormFilterBundle(),
            new Knp\Bundle\PaginatorBundle\KnpPaginatorBundle(),
            new Stof\DoctrineExtensionsBundle\StofDoctrineExtensionsBundle(),
            new Flexix\MenuBundle\FlexixMenuBundle(),
            new Knp\Bundle\MenuBundle\KnpMenuBundle(),
            new Flexix\PathAnalyzerBundle\FlexixPathAnalyzerBundle(),
        ];

        if (in_array($this->getEnvironment(), ['dev', 'test'], true)) {
            $bundles[] = new Symfony\Bundle\DebugBundle\DebugBundle();
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
            $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
        }

        return $bundles;
    }

    public function getRootDir()
    {
        return __DIR__;
    }

    public function getCacheDir()
    {
        return dirname(__DIR__).'/var/cache/'.$this->getEnvironment();
    }

    public function getLogDir()
    {
        return dirname(__DIR__).'/var/logs';
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load($this->getRootDir().'/config/config_'.$this->getEnvironment().'.yml');
    }
}
