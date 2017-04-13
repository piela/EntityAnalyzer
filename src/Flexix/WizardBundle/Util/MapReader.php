<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Flexix\WizardBundle\Util;

class MapReader {

    protected $entitiesMap;

    public function __construct($entitiesMap) {

        $this->entitiesMap = $entitiesMap;
    }

    public function getEntities() {
    
        $result=[];
        
        foreach($this->entitiesMap as $bundleName=> $entities)
        {
            $result[$bundleName]=[];
           $this->readEntities($entities,$result[$bundleName]);
        }
        
        return ['entities'=>$result];
    }
    
    
    protected function readEntities($entities,&$result)
    {
        foreach($entities as $entity)
        {
            $entityNamespaceArr=explode('\\',$entity['entity_class']);
            
            $result[sprintf('%s (%s)',$entity['alias'],end($entityNamespaceArr))]=$entity['entity_class'];
        }
        
    }
    

}
