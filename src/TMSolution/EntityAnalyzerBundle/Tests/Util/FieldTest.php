<?php

namespace TMSolution\EntityAnalyzerBundle\Util;

/**
 * Description of EntityAnalyzer
 *
 * @author Mariusz
 */
class FieldTest {
    
    function testGetName() {
        return $this->name;
    }

    function testGetSetterName() {
        return $this->setterName;
    }

    function testGetAssociationType() {
        return $this->associationType;
    }

    function testSetName($name) {
        $this->name = $name;
    }

    function testSetSetterName($setterName) {
        $this->setterName = $setterName;
    }

    function testSetAssociationType($associationType) {
        $this->associationType = $associationType;
    }

    function testGetEntityName() {
        return $this->entityName;
    }

    function testSetEntityName($entityName) {
        $this->entityName = $entityName;
    }

    function testGetType() {
        return $this->type;
    }

    function testSetType($type) {
        $this->type = $type;
    }

}
