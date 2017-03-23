<?php

namespace TMSolution\EntityAnalyzerBundle\Util;

use \TMSolution\EntityAnalyzerBundle\Util\EntityAnalyze;
use \TMSolution\EntityAnalyzerBundle\Util\Field;

/**
 * Description of EntityAnalyzer
 *
 * @author Mariusz
 */
class EntityAnalyzer {

    protected $entityClass;
    protected $manager;
    protected $metadata;
    protected $reflectionClass;
    protected $association = [
        1 => 'OneToOne',
        2 => 'ManyToOne',
        4 => 'OneToMany',
        8 => 'ManyToMany',
        3 => 'ToOne',
        12 => 'ToMany'];

    public function __construct($orm, $entityClass, $managerName = null) {
        $this->entityClass = $entityClass;
        $this->manager = $orm->getManager($managerName);
        $this->metadata = $this->getManager()->getClassMetadata($this->entityClass);
        $this->reflectionClass = $this->metadata->getReflectionClass();
    }

    public function getEntityAnalyze() {
        $entityAnalize = new EntityAnalyze($this->getEntityClass());
        $entityAnalize->setFields($this->getFields());
        return $entityAnalize;
    }
    
    protected function getEntityClass() {
         return $this->entityClass;
    }
    protected function getMetadata() {
        return $this->metadata;
    }

    protected function getReflectionClass() {
        return $this->reflectionClass;
    }

    protected function findMethodByPrefix($propertyName, $methodPrefixes) {
        if (is_string($methodPrefixes)) {
            $methodPrefixes = array($methodPrefixes);
        }
        foreach ($methodPrefixes as $methodPrefix) {
            $method = $this->checktMethodExists(\sprintf('%s%s', $methodPrefix, ucfirst($propertyName)));
            if ($method !== false) {
                return $method;
            }
        }
        return false;
    }

    protected function checktMethodExists($methodName) {
        $reflectionClass = $this->getReflectionClass();
        if ($reflectionClass->hasMethod($methodName) && $reflectionClass->getMethod($methodName)->isPublic()) {
            return $methodName;
        }
        return false;
    }

    protected function getFields($metadata) {
        $fields = [];
        foreach ($metadata->fieldMappings as $field => $parameters) {
            $field = new Field();
            $field->setName($parameters['fieldName']);
            $field->setType($parameters['type']);
            $field->setSetterName($this->findMethodByPrefix($parameters['fieldName'], ['set', 'add']));
            $fields[$field->getName()] = $field;
        }
        foreach ($metadata->associationMappings as $field => $parameters) {
            $field = new Field();
            $field->setName($parameters['fieldName']);
            $field->setType('object');
            $field->setEntityName($parameters['targetEntity']);
            $field->setAssociationType($this->association[$parameters['type']]);
            $field->setSetterName($this->findMethodByPrefix($parameters['fieldName'], ['set', 'add']));
            $fields[$field->getName()] = $field;
        }
        return $fields;
    }

}
