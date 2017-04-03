<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace TMSolution\PrototypeBundle\Util;

/**
 * Description of Ticket
 *
 * @author Mariusz
 */
class Ticket {
   
    protected $driver;
    protected $object;

    
    function getDriver() {
        return $this->driver;
    }

    function getObject() {
        return $this->object;
    }

    function setDriver($driver) {
        $this->driver = $driver;
    }

    function setObject($object) {
        $this->object = $object;
    }


    
}
