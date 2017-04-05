<?php

namespace TMSolution\EntityAnalyzerBundle\Tests\Util;

use TMSolution\EntityAnalyzerBundle\Util\EntityAnalyze;
use \PHPUnit\Framework\TestCase;

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

}
