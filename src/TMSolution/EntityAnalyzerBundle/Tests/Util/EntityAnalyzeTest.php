<?php
namespace TMSolution\EntityAnalyzerBundle\Util;


/**
 * Description of EntityAnalyzer
 *
 * @author Mariusz
 */
class EntityAnalyze {
 
    protected $entityClass = null;
    protected $fields = array();
    
    public function __construct($entityClass) {
        
        $this->entityClass=$entityClass;
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
    
    
    function addField($fieldName,$field) {
        $this->fields[$fieldName] = $field;
    }


    
}
