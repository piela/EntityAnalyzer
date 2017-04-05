<?php

namespace TMSolution\EntityAnalyzerBundle\Util;

use TMSolution\EntityAnalyzerBundle\Util\Field;

/**
 * Description of EntityAnalyzer
 *
 * @author Mariusz Piela <mariuszpiela@tmsolution.pl>
 */
class ObjectField extends Field {

    protected $associationType;
    protected $entityName;

    public function getAssociationType() {
        return $this->associationType;
    }

    public function setAssociationType($associationType) {
        $this->associationType = $associationType;
    }

    public function getEntityName() {
        return $this->entityName;
    }

    public function setEntityName($entityName) {
        $this->entityName = $entityName;
    }

    public function dump() {

        $properties = [
            'association_type' => $this->associationType,
            'entity_name' => $this->entityName,
        ];
        
        return array_merge(parent::dump(), $properties);
    }

}
