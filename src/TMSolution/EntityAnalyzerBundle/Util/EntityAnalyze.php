<?php

namespace TMSolution\EntityAnalyzerBundle\Util;

/**
 * Description of EntityAnalyzer
 *
 * @author Mariusz Piela <mariuszpiela@tmsolution.pl>
 */

/**
 * Description of EntityAnalyzer
 *
 * @author Mariusz Piela <mariuszpiela@tmsolution.pl>
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

    public function getEntityClass() {
        return $this->entityClass;
    }

    public function getFields() {
        return $this->fields;
    }

    public function setEntityClass($entityClass) {
        $this->entityClass = $entityClass;
    }

    public function setFields($fields) {
        $this->fields = $fields;
    }

    public function addField($fieldName, $field) {
        $this->fields[$fieldName] = $field;
    }

    public function getParentEntities() {
        return $this->parentEntities;
    }

    public function getChildEntities() {
        return $this->childEntities;
    }

    public function getAssociations() {
        return $this->associations;
    }

    public function setParentEntities($parentEntities) {
        $this->parentEntities = $parentEntities;
    }

    public function addParentEntity($fieldName, $field) {
        $this->parentEntities[$fieldName] = $field;
    }

    public function setChildEntities($childEntities) {
        $this->childEntities = $childEntities;
    }

    public function addChildEntity($fieldName, $field) {
        $this->childEntities[$fieldName] = $field;
    }

    public function setAssociations($associations) {
        $this->associations = $associations;
    }

    public function addAssociation($fieldName, $field) {
        $this->associations[$fieldName] = $field;
    }
    
    public function dump()
    {
        return [
           'entity_class' =>$this->entityClass,
           'fields' => $this->fields,
           'parent_entities' =>$this->parentEntities,
           'child_entities' => $this->childEntities ,
           'associations' =>$this->associations,
        ];
        
        
    }
}
