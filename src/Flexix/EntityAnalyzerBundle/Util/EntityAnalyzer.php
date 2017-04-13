<?php

namespace Flexix\EntityAnalyzerBundle\Util;

use \Flexix\EntityAnalyzerBundle\Util\EntityAnalyze;
use \Flexix\EntityAnalyzerBundle\Util\Field;
use \Flexix\EntityAnalyzerBundle\Util\ObjectField;
use Flexix\EntityAnalyzerBundle\Association;

/**
 * Description of EntityAnalyzer
 *
 * @author Mariusz Piela <mariuszpiela@tmsolution.pl>
 */
class EntityAnalyzer {

    protected $entityClass;
    protected $manager;
    protected $metadata;
    protected $reflectionClass;

    public function __construct($orm, $entityClass, $managerName = null) {
        $this->entityClass = $entityClass;
        $this->manager = $orm->getManager($managerName);
        $this->metadata = $orm->getManager()->getClassMetadata($entityClass);
        $this->reflectionClass = $this->metadata->getReflectionClass();
    }

    public function getEntityAnalyze() {
        return $this->analize();
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

    protected function findMethodByPrefix($propertyName, $methodPrefixes, $entityName=null) {
        
   
        if (is_string($methodPrefixes)) {
            $methodPrefixes = array($methodPrefixes);
        }
        foreach ($methodPrefixes as $methodPrefix) {
            $method = $this->checktMethodExists(\sprintf('%s%s', $methodPrefix, ucfirst($propertyName)));
            if ($method !== false) {
                return $method;
            }
            if ($entityName) {
                
                $method = $this->checktMethodExists(\sprintf('%s%s', $methodPrefix, $entityName));
                if ($method !== false) {
                    return $method;
                }
            }
        }
      
    }

    protected function checktMethodExists($methodName) {
        $reflectionClass = $this->getReflectionClass();
        if ($reflectionClass->hasMethod($methodName) && $reflectionClass->getMethod($methodName)->isPublic()) {
            return $methodName;
        }
        return false;
    }

    protected function analize() {

        $entityAnalyze = new EntityAnalyze($this->getEntityClass());


        foreach ($this->metadata->fieldMappings as $field => $parameters) {

            $field = new Field();
            $field->setName($parameters['fieldName']);
            $field->setType($parameters['type']);
            $field->setSetterName($this->findMethodByPrefix($parameters['fieldName'], ['set', 'add']));
            $field->setMetadata($parameters);
            $entityAnalyze->addField($field->getName(), $field);
        }

        foreach ($this->metadata->associationMappings as $field => $parameters) {

            $field = new ObjectField();
            $field->setName($parameters['fieldName']);
            $field->setType('object');
            $entityNamespaceArray=explode('\\', $parameters['targetEntity']);
            $entityName = end($entityNamespaceArray);
            $field->setEntityName($parameters['targetEntity']);
            $field->setAssociationType($parameters['type']);
            $field->setSetterName($this->findMethodByPrefix($parameters['fieldName'], ['set', 'add'],$entityName));
            $field->setMetadata($parameters);
            $entityAnalyze->addField($field->getName(), $field);
            $entityAnalyze->addAssociation($field->getName(), $field);

            if (in_array($parameters['type'], [Association::MANY_TO_MANY, Association::ONE_TO_ONE, Association::ONE_TO_MANY, Association::TO_MANY])) {
                $entityAnalyze->addChildEntity($field->getName(), $field);
            }

            if (in_array($parameters['type'], [Association::MANY_TO_MANY, Association::MANY_TO_ONE, Association::TO_ONE])) {
                $entityAnalyze->addParentEntity($field->getName(), $field);
            }
        }

        return $entityAnalyze;
    }

}
