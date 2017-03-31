<?php

namespace TMSolution\PrototypeBundle\Tests\Util;

use TMSolution\PrototypeBundle\Util\RequestAnalyzer;
use Symfony\Component\Yaml\Yaml;
use TMSolution\MapperBundle\Util\ApplicationMapper;
use TMSolution\MapperBundle\Util\EntityMapper;
use \PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use TMSolution\PrototypeBundle\Util\ControllerConfiguration;

/**
 * Description of EntityAnalyzer
 * php  app/phpunit.phar   --bootstrap=./app/autoload.php ./src/TMSolution/PrototypeBundle/Tests/Util/RequestAnalyzerTest.php
 * @author Mariusz
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
