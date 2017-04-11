<?php

namespace TMSolution\PrototypeBundle\Util;

use TMSolution\PrototypeBundle\Util\DataAdapterInterface;

class DataAdapter implements DataAdapterInterface {

    protected $object;

    public function setObject($object) {

        $this->object = $object;
    }

    public function getData() {
      
        return $this->object;
    }

    public function getTemplateData($templateData) {

        return $templateData;
    }

}
