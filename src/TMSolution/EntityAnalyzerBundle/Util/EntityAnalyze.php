<?php

namespace TMSolution\EntityAnalyzerBundle\Util;

/**
 * Description of EntityAnalyzer
 *
 * @author Mariusz
 */

/**
 * Description of EntityAnalyzer
 *
 * @author Mariusz
 */
class EntityAnalyze {

    protected $entityClass = null;
    protected $fields = array();
    protected $parentEntities = [];
    protected $childEntities = [];
    protected $associations = [];
    

    public function __construct($entityClass) {

        $this->entityClass = $entityClass;
    }

    function getEntityClass() {
        return $this->entityClass;
    }

    function getFields() {
        return $this->fields;
    }

    function setEntityClass($entityClass) {
        $this->entityClass = $entityClass;
    }

    function setFields($fields) {
        $this->fields = $fields;
    }

    function addField($fieldName, $field) {
        $this->fields[$fieldName] = $field;
    }

    function getParentEntities() {
        return $this->parentEntities;
    }

    function getChildEntities() {
        return $this->childEntities;
    }

    function getAssociations() {
        return $this->associations;
    }

    function setParentEntities($parentEntities) {
        $this->parentEntities = $parentEntities;
    }

    function addParentEntity($fieldName, $field) {
        $this->parentEntities[$fieldName] = $field;
    }

    function setChildEntities($childEntities) {
        $this->childEntities = $childEntities;
    }

    function addChildEntity($fieldName, $field) {
        $this->childEntities[$fieldName] = $field;
    }

    function setAssociations($associations) {
        $this->associations = $associations;
    }

    function addAssociation($fieldName, $field) {
        $this->associations[$fieldName] = $field;
    }

 

}
