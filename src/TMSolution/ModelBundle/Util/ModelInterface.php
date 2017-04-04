<?php

//TMSolution\ModelBundle\Util\ModelInterface
namespace TMSolution\ModelBundle\Util;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


interface ModelInterface {
    
    public function findOneById($entityClass, $id); 
    public function search($entityClass,$query); 
    public function save($entity) ;
    public function update() ;
    public function delete($entity) ;
}
