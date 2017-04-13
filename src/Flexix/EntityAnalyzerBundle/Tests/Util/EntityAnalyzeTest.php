<?php

namespace Flexix\EntityAnalyzerBundle\Tests\Util;

use Flexix\EntityAnalyzerBundle\Util\EntityAnalyze;
use \PHPUnit\Framework\TestCase;
use Flexix\EntityAnalyzerBundle\Util\EntityAnalyzer;

/**
 * Description of EntityAnalyzer
 *
 * @author Mariusz Piela <mariuszpiela@tmsolution.pl>
 */
class EntityAnalyzeTest extends TestCase {

    protected static $entityClass = 'Some/Class/Name';
    protected static $entityAnalyze;

    public static function setupBeforeClass() {
        self::$entityAnalyze = new EntityAnalyze(self::$entityClass);
    }

    function testGetEntityClass() {
        self::$entityAnalyze->setEntityClass(self::$entityClass);
        $this->assertEquals(self::$entityClass, self::$entityAnalyze->getEntityClass());
    }

    function testGetFields() {
        $fields = ["a", "b", "c"];
        self::$entityAnalyze->setFields($fields);
        $this->assertEquals($fields, self::$entityAnalyze->getFields());
    }

    function testSetEntityClass() {
        self::$entityAnalyze->setEntityClass(self::$entityClass);
        $this->assertEquals(self::$entityClass, self::$entityAnalyze->getEntityClass());
    }

    function testSetFields() {
        $fields = ["a", "b", "c"];
        self::$entityAnalyze->setFields($fields);
        $this->assertEquals($fields, self::$entityAnalyze->getFields());
    }

    function testAddField() {
        $fieldName = "aaaa";
        $field = new \stdClass();
        self::$entityAnalyze->addField($fieldName, $field);
        $fields = self::$entityAnalyze->getFields();
        $this->assertEquals($fields[$fieldName], $field);
    }
    
    
     function testDump() {
        $fieldName = "aaaa";
        $field = new \stdClass();
        self::$entityAnalyze->addField($fieldName, $field);
        $fields = self::$entityAnalyze->getFields();
        $this->assertEquals($fields[$fieldName], $field);
    }

}
