<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace TMSolution\MenuBundle\Model;

use TMSolution\PrototypeBundle\Util\DataAdapterInterface;
use TMSolution\PrototypeBundle\Util\DataAdapter;

/**
 * Description of Adapter
 *
 * @author Mariusz
 */
class PaginatorAdapter extends DataAdapter implements DataAdapterInterface {

    public function getData() {

        return $this->object->getItems();
    }

    public function getTemplateData($templateData) {
        $templateData['paginator'] = $this->object;
        return $templateData;
    }

}
