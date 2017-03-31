<?php

//TMSolution\PrototypeBundle\Util\ControllerConfiguration

namespace TMSolution\ControllerConfigurationBundle\Util;


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
