<?php

namespace TMSolution\PrototypeBundle\Util;

use TMSolution\ConfigurationBundle\Util\ConfigurationInterface;

class ControllerDriver {

    protected $configuration;

    public function __construct(ConfigurationInterface $configuration) {
        $this->configuration = $configuration;
    }

    public function isActionAllowed() {
        return $this->configuration->get('allowed');
    }


    public function getEntityClass() {

        return  $this->configuration->get('requestAnalyze.entityClass');
        
    }

    public function getApplicationPath() {

        return  $this->configuration->get('requestAnalyze.applicationPath');
        
    } 
    
    
    public function getEntitiesPath() {

        return  $this->configuration->get('requestAnalyze.entitiesPath');
        
    } 
    
    
    public function returnResultToView()
    {
        if($this->configuration->has('model.returnResultToView') )
        {
           return  $this->configuration->get('model.returnResultToView');
        }
        else
        {
            return false;
        }
    }
    
    
    
    public function shouldRedirect()
    {
        if($this->configuration->has('redirect') && $this->configuration->get('redirect')!=null)
        {
            return true;
        }
    }
    
    
    public function getRedirectRoute($arguments)
    {
        
        if($this->configuration->has('redirect') && $this->configuration->get('redirect')!=null)
        {
            return true;
        }
        else
        {
            throw new \Exception('No route to redirect');
        }
    }
    
    

    public function getModel() {

        if ($this->configuration->has('model')) {

            $model = $this->configuration->get('model');
            
            if (!array_key_exists('name', $model)) {
                throw new \Exception('Model must have defined name in configuration');
            } 

            if (!array_key_exists('method', $model)) {
                throw new \Exception('Model must have defined method in configuration');
            }

            if (!array_key_exists('type', $model)  ) {
                $model['type'] = 'service';
            }
            
            if (!array_key_exists('property', $model)  ) {
                $model['property'] = 'result';
            }
            
            return $model;
        }
        
    }

    public function getFormTypeClass() {

        $formTypeClass = $this->configuration->get('formTypeClass');
   
        return  $formTypeClass;
    }

    
    public function getTemplate() {

        $template = $this->configuration->get('templates.element');
   
        return  $template;
    }

    
}
