<?php

//TMSolution\PrototypeBundle\Util\ControllerConfiguration

namespace TMSolution\PrototypeBundle\Util;

use TMSolution\ConfigurationBundle\Util\ConfigurationInterface;
use TMSolution\ConfigurationBundle\Util\Configuration;

class ControllerConfiguration extends Configuration {

    protected $action;

    function getAction() {
        return $this->action;
    }

    function setAction($action) {
        $this->action = $action;
    }

    

}
