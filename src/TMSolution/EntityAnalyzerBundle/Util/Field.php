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
    protected $type;
    protected $required;
    protected $metadata;

    public function getRequired() {
        return $this->required;
    }

    public function setRequired($required) {
        $this->required = $required;
    }

    public function getName() {
        return $this->name;
    }

    public function getSetterName() {
        return $this->setterName;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function setSetterName($setterName) {
        $this->setterName = $setterName;
    }

    public function getType() {
        return $this->type;
    }

    public function setType($type) {
        $this->type = $type;
    }

    public function getMetadata() {
        return $this->metadata;
    }

    public function setMetadata($metadata) {
        $this->metadata = $metadata;
    }

     protected function getSnakeCase($text) {
        return ltrim(strtolower(preg_replace('/[A-Z]([A-Z](?![a-z]))*/', '_$0', $text)), '_');
    }
    
    
    public function dump() {

        $this->metadata
        
        
        return [
            'name' => $this->name,
            'setter_name' => $this->setterName,
            'type' => $this->type,
            'metadata' => $this->metadata,
        ];
    }

}
