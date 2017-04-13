<?php

namespace Flexix\EntityAnalyzerBundle\Tests\Util;

use Flexix\EntityAnalyzerBundle\Util\Field;
use \PHPUnit\Framework\TestCase;

/**
 * Description of EntityAnalyzer
 *
 * @author Mariusz Piela <mariuszpiela@tmsolution.pl>
 */
class FieldTest extends  TestCase {

    protected static $field;

    public static function setUpBeforeClass() {
        self::$field = new Field();
    }

    function testGetName() {
        $name = 'test';
        self::$field->setName($name);
        $this->assertEquals('test', self::$field->getName());
    }

    function testGetSetterName() {
        $name = 'test';
        self::$field->setSetterName($name);
        $this->assertEquals('test', self::$field->getSetterName());
    }

 

    function testSetName() {
        $name = 'test';
        self::$field->setName($name);
        $this->assertEquals('test', self::$field->getName());
    }

    function testSetSetterName() {
        $name = 'test';
        self::$field->setSetterName($name);
        $this->assertEquals('test', self::$field->getSetterName());
    }

 

    function testGetType() {
        $name = 'test';
        self::$field->setType($name);
        $this->assertEquals('test', self::$field->getType());
    }

    function testSetType() {
        $name = 'test';
        self::$field->setType($name);
        $this->assertEquals('test', self::$field->getType());
    }

}
