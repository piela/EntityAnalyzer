<?php

namespace TMSolution\PrototypeBundle\Tests\Util;

use TMSolution\PrototypeBundle\Util\ControllerDriver;
use TMSolution\ControllerConfigurationBundle\Util\ControllerConfiguration;
use TMSolution\PrototypeBundle\Sample\SampleLogger;
use TMSolution\PrototypeBundle\Controller\PrototypeController;
use TMSolution\RequestAnalyzerBundle\Util\RequestAnalyzer;
use \PHPUnit\Framework\TestCase;

/**
 * 
 * php  app/phpunit.phar   --bootstrap=./app/autoload.php ./src/TMSolution/PrototypeBundle/Tests/Util/ControllerDriverTest.php
 * @author Mariusz,TomDyg
 */
class ControllerDriverTest extends TestCase {
   
    protected static $controllerDriver;
   
    public static function setupBeforeClass() {
        self::$controllerDriver = new ControllerDriver(new ControllerConfiguration());
    } 
    
    public function testIsActionAllowed() {
        $this->assertTrue(self::$controllerDriver->isActionAllowed());
    }
    
    public function testGetEntityClass() {
        
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
