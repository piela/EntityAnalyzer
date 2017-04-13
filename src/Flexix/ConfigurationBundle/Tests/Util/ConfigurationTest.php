<?php

namespace Flexix\ConfigurationBundle\Tests\Util;

use Flexix\ConfigurationBundle\Util\Configuration;
use Flexix\EntityAnalyzerBundle\Util\EntityAnalyze;
use \PHPUnit\Framework\TestCase;

/**
 * Description of EntityAnalyzer
 *php  app/phpunit.phar   --bootstrap=./app/autoload.php ./src/Flexix/ConfigurationBundle/Tests/Util/ConfigurationTest.php
 * @author Mariusz Piela <mariuszpiela@tmsolution.pl>
 */
class ConfigurationTest extends TestCase {

    protected static $configuration;
    protected static $configArray=['one'=>'one','two'=>['two.one'=>'two.one','two.two'=>'two.two'],'three'=>'three'];
    protected static $expectedArray=['one'=>'one','two'=>['two.one'=>'two.two.two','two.two'=>'two.two','two.three'=>'two.three'],'three'=>'three','four'=>'four'];

    public static function setupBeforeClass() {
        self::$configuration = new Configuration(self::$configArray);
    }
    
    
    public function testMerge_Array() {
        $array=['two'=>['two.one'=>'two.two.two','two.three'=>'two.three'],'four'=>'four'];
        self::$configuration->merge($array);
        $resultData=self::$configuration->getData();
        $this->assertEquals($resultData,self::$expectedArray);
    }
    
    public function testMerge_Configuration() {
        
        $array=['two'=>['two.one'=>'two.two.two','two.three'=>'two.three'],'four'=>'four'];
        $configuration= new Configuration($array);
        self::$configuration->merge($configuration);
        $resultData=self::$configuration->getData();
        $this->assertEquals($resultData,self::$expectedArray);
        
    }

    /**
     * @expectedException \Exception
     */
    public function testMerge_Exception() {
        
        self::$configuration->merge(new \stdClass()); 
    }

    /**
     * @expectedException \Exception
     */
    public static function testConstruct_Exception() {
        
        new Configuration(new \stdClass());

    }
    
    

}
