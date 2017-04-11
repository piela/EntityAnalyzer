<?php

namespace TMSolution\PrototypeBundle\Util;

interface DataAdapterInterface
{
    public function setObject($object);    
    public function getData();
    public function getTemplateData($templateData);    
} 