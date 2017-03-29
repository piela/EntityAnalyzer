<?php

namespace TMSolution\PrototypeBundle\Util;

use TMSolution\ControllerConfigurationBundle\Util\ConfigurationInterface;

class ControllerConfiguration implements ConfigurationInterface {


    public function getSearchFormTypeClass() {
        
        return $this->get('searchFormType');
        
    }

    public function getFormTypeClass() {
        
        return $this->get('formType');
    }

    public function getModel() {
        
        return $this->get('model');
    }

    public function getTemplate($actionName) {
        
        return $this->get('templates.element');
    }

    public function getRedirectRoute() {
        
        return $this->get('templates.redirect.route');
    }
    
}
