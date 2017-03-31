<?php

namespace TMSolution\PrototypeBundle\Tests\Util;

use TMSolution\PrototypeBundle\Util\RequestAnalyzer;
use \PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Yaml\Yaml;
use TMSolution\MapperBundle\Util\ApplicationMapper;
use TMSolution\MapperBundle\Util\EntityMapper;
use TMSolution\ConfigurationBundle\Util\Configuration;
use TMSolution\PrototypeBundle\Util\ControllerConfiguration;
use TMSolution\PrototypeBundle\Util\ControllerConfigurationFactory;

/**
 * Description of EntityAnalyzer
 * php  app/phpunit.phar   --bootstrap=./app/autoload.php ./src/TMSolution/PrototypeBundle/Tests/Util/ControllerConfigurationFactoryTest.php
 * @author Mariusz
 */
class ControllerConfigurationFactoryTest extends TestCase {

    const _ALIAS = 'payment-frequency';
    const _APPLICATION_PATH = 'admin/some/other/path';
    const _ENTITIES_PATH = 'discount/2/measure-unit/3/payment-frequency';
    const _ID = '7';

    static protected $request;
    static protected $mapperConfiguration;
    static protected $prototypeConfiguration;
    static protected $developerConfiguration;

    public static function setupBeforeClass() {

        self::$request = new Request(['id' => self::_ID], [/* post */], [
            'applicationPath' => self::_APPLICATION_PATH,
            'entitiesPath' => self::_ENTITIES_PATH
        ]);

        self::$mapperConfiguration = file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'testMapper.yml');
        self::$prototypeConfiguration = file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'testPrototypeConfiguration.yml');
        self::$developerConfiguration = file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'testDeveloperConfiguration.yml');
    }

    protected function createConfiguration() {
        
        $mapperConfiguration = Yaml::parse(self::$mapperConfiguration);

        $appliactionMapper = new ApplicationMapper($mapperConfiguration['tm_solution_mapper']['applications']);

        $entityMapper = new EntityMapper($mapperConfiguration['tm_solution_mapper']['entities']);

        $requestAnalyzer = new RequestAnalyzer($appliactionMapper, $entityMapper);

        $prototypeConfiguration = Yaml::parse(self::$prototypeConfiguration);
        $developerConfiguration = Yaml::parse(self::$developerConfiguration);

        $baseConfiguration = new Configuration($prototypeConfiguration['tm_solution_prototype']);
        $configurationFactory = new ControllerConfigurationFactory($baseConfiguration, $requestAnalyzer);
        $developerConfiguration = new Configuration($developerConfiguration['tm_solution_prototype']);
        $configurationFactory->addConfiguration($developerConfiguration, self::_APPLICATION_PATH, self::_ALIAS);
        return $configurationFactory->createConfiguration(self::$request, new ControllerConfiguration(), 'new');
    }

    public function testCreateConfiguration_instaceOfControllerConfiguration() {

        $this->assertInstanceOf('TMSolution\PrototypeBundle\Util\ControllerConfiguration', $this->createConfiguration());
    }
    
    public function testCreateConfiguration_overridingAttributes() {
        
        $configuration=$this->createConfiguration();
        
        $this->assertEquals('Default\Container\SomeElephant.html.twig',$configuration->get('templates.container') );
    }
    

}
