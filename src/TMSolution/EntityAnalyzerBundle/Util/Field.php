<?php

namespace TMSolution\EntityAnalyzerBundle\Util;

/**
 * Description of EntityAnalyzer
 *
 * @author Mariusz Piela <mariuszpiela@tmsolution.pl>
 */
class Field {
    protected $name;
    protected $setterName;
    protected $associationType;
    protected $entityName;
    protected $type;
    protected $metadata;

    function getName() {
        return $this->name;
    }

    function getSetterName() {
        return $this->setterName;
    }

    function getAssociationType() {
        return $this->associationType;
    }

    function setName($name) {
        $this->name = $name;
    }

    function setSetterName($setterName) {
        $this->setterName = $setterName;
    }

    function setAssociationType($associationType) {
        $this->associationType = $associationType;
    }

    function getEntityName() {
        return $this->entityName;
    }

    function setEntityName($entityName) {
        $this->entityName = $entityName;
    }

    function getType() {
        return $this->type;
    }

    function setType($type) {
        $this->type = $type;
    }
    
    function getMetadata() {
        return $this->metadata;
    }

    function setMetadata($metadata) {
        $this->metadata = $metadata;
    }

}
