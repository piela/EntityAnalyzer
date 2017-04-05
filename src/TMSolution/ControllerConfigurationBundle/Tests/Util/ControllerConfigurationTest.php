<?php

namespace TMSolution\ControllerConfigurationBundle\Tests\Util;

use TMSolution\RequestAnalyzerBundle\Util\RequestAnalyzer;
use Symfony\Component\Yaml\Yaml;
use TMSolution\MapperBundle\Util\ApplicationMapper;
use TMSolution\MapperBundle\Util\EntityMapper;
use \PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use TMSolution\ControllerConfigurationBundle\Util\ControllerConfiguration;

/**
 * Description of EntityAnalyzer
 * php  app/phpunit.phar   --bootstrap=./app/autoload.php ./src/TMSolution/PrototypeBundle/Tests/Util/RequestAnalyzerTest.php
 * @author Mariusz Piela <mariuszpiela@tmsolution.pl>
 */
class ControllerConfigurationTest extends TestCase {

    protected static $controllerConfiguration;
    
    public static function setupBeforeClass() {

        self::$controllerConfiguration = new ControllerConfiguration();
    }

    public function testGetAction() {

        self::$controllerConfiguration->setAction('aaaa');
        $this->assertEquals('aaaa', self::$controllerConfiguration->getAction());
    }

    public function testSetAction() {

        self::$controllerConfiguration->setAction('aaaa');
        $this->assertEquals('aaaa', self::$controllerConfiguration->getAction());
    }

}
