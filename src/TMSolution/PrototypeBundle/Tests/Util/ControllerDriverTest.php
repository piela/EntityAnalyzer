<?php

namespace TMSolution\PrototypeBundle\Tests\Util;

use Symfony\Component\Yaml\Yaml;
use TMSolution\PrototypeBundle\Util\ControllerDriver;
use TMSolution\ControllerConfigurationBundle\Util\ControllerConfiguration;
use TMSolution\MapperBundle\Util\ApplicationMapper;
use TMSolution\PrototypeBundle\Sample\SampleLogger;
use TMSolution\PrototypeBundle\Controller\PrototypeController;
use TMSolution\RequestAnalyzerBundle\Util\RequestAnalyzer;
use \PHPUnit\Framework\TestCase;

/**
 * 
 * php  app/phpunit.phar   --bootstrap=./app/autoload.php ./src/TMSolution/PrototypeBundle/Tests/Util/ControllerDriverTest.php
 * @author Mariusz Piela <mariuszpiela@tmsolution.pl>,TomDyg
 */
class ControllerDriverTest extends TestCase {
   
    const _APPLICATION_PATH = 'admin/some/other/path';
    const _ENTITIES_PATH = 'discount/2/measure-unit/3/payment-frequency';
    const _ID = '7';
    
   protected static $expected_entity_name = 'TMSolution\EntityAnalyzerBundle\Entity\Discount';
   static protected $controllerDriver;
   static protected $request;
   
    public static function setupBeforeClass() {
  
        $configuration = Yaml::parse(file_get_contents(__DIR__.DIRECTORY_SEPARATOR.'testConfiguration.yml'));
        $controllerConfiguration=new ControllerConfiguration($configuration['tm_solution_prototype']['base']);
        self::$controllerDriver=new ControllerDriver($controllerConfiguration);
        
        /*self::$request = new Request(['id' => self::_ID], [], [
            'applicationPath' => self::_APPLICATION_PATH,
            'entitiesPath' => self::_ENTITIES_PATH
        ]); */
    } 
    
    public function testIsActionAllowed() {
        
        $this->assertTrue(self::$controllerDriver->isActionAllowed());
    }
    
    public function testGetEntityClass() {
        
       /* $mapperConfiguration = Yaml::parse(file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'testMapper.yml'));
        $appliactionMapper = new ApplicationMapper($mapperConfiguration['tm_solution_mapper']['applications']);
        $entityMapper = new EntityMapper($mapperConfiguration['tm_solution_mapper']['entities']);
        $requestAnalyzer = new RequestAnalyzer($appliactionMapper, $entityMapper);
        $requestAnalyze = $requestAnalyzer->analyze(self::$request); */
        
        $configuration = Yaml::parse(file_get_contents(__DIR__.DIRECTORY_SEPARATOR.'testMapper.yml'));
        $controllerConfiguration=new ControllerConfiguration($configuration['tm_solution_mapper']['entities']['tm_solution_entity_analyzer']['discount']);
        $controllerDriver=new ControllerDriver($controllerConfiguration);
        $this->assertEquals($controllerDriver->getEntityClass(),self::$expected_entity_name);
    }
    
    public function testGetApplicationPath() {
        
    }
    
    public function testGetEntitiesPath() {
        
    }
    
    public function testReturnResultToView() {
        
    }
    
    public function testGetResultParameter() {
        
    }
    
    public function testShouldRedirect() {
        
    }
    
    public function testRedirectionRouteParameters() {
        
    }
    
    public function testGetModel() {
        
    }
    
    public function testHasModel() {
        
    }
    
    public function testFormTypeClass() {
        
    }
    
    public function testGetFormAction() {
        
    }
    
    public function testGetTemplate() {
        
    }
    

    
    
   

}
