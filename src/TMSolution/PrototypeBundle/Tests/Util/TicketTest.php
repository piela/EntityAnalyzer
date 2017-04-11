<?php

namespace TMSolution\PrototypeBundle\Tests\Util;

use TMSolution\PrototypeBundle\Util\Ticket;
use Symfony\Component\Yaml\Yaml;
use TMSolution\PrototypeBundle\Util\ControllerDriver;
use TMSolution\ControllerConfigurationBundle\Util\ControllerConfiguration;
use TMSolution\MapperBundle\Util\ApplicationMapper;
use TMSolution\PrototypeBundle\Sample\SampleLogger;
use TMSolution\PrototypeBundle\Controller\PrototypeController;
use TMSolution\MapperBundle\Util\EntityMapper;
use TMSolution\ConfigurationBundle\Util\Configuration;
use TMSolution\ControllerConfigurationBundle\Util\ControllerConfigurationFactory;
use TMSolution\RequestAnalyzerBundle\Util\RequestAnalyzer;
use Symfony\Component\HttpFoundation\Request;
use \PHPUnit\Framework\TestCase;

/**
 * 
 * php  app/phpunit.phar   --bootstrap=./app/autoload.php ./src/TMSolution/PrototypeBundle/Tests/Util/TicketTest.php
 * @author Mariusz Piela <mariuszpiela@tmsolution.pl>,TomDyg
 */
class TicketTest extends TestCase {

    const _ALIAS = 'payment-frequency';
    const _APPLICATION_PATH = 'admin/some/other/path';
    const _ENTITIES_PATH = 'discount/2/measure-unit/3/payment-frequency';
    const _ID = '7';
    const _MODEL_NAME = 'get';

    static protected $ticket;
    static protected $mapperConfiguration;
    static protected $prototypeConfiguration;
    static protected $developerConfiguration;

    public static function setupBeforeClass() {
        self::$ticket = new Ticket();
    }

    protected function getDriver() {

        $configuration = Yaml::parse(file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'testConfiguration.yml'));
        $controllerConfiguration = new ControllerConfiguration($configuration['tm_solution_prototype']['base']); 
        return new ControllerDriver($controllerConfiguration);
    }

    
    public function testGetDriver() {
        $controllerDriver = $this->getDriver();
        self::$ticket->setDriver($controllerDriver);
        $this->assertEquals($controllerDriver, self::$ticket->getDriver());
    }

    public function testGetObject() {
        $driverObject = $this->getDriver();
        self::$ticket->setObject($driverObject);
        $this->assertEquals($driverObject, self::$ticket->getDriver());
    }

    public function testSetObject() {
        $driverObject = $this->getDriver();
        self::$ticket->setObject($driverObject);
        $this->assertEquals($driverObject, self::$ticket->getDriver());
    }

    public function testSetDriver() {
        $controllerDriver = $this->getDriver();
        self::$ticket->setDriver($controllerDriver);
        $this->assertEquals($controllerDriver, self::$ticket->getDriver());
    }

}
